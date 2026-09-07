<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Member;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Show QR code scanning interface for attendance
     */
    public function scanInterface(Meeting $meeting)
    {
        return view('meetings.attendance-scan', compact('meeting'));
    }

    /**
     * Handle member check-in via QR code
     */
    public function checkIn(Request $request, $meetingUuid)
    {
        $meeting = Meeting::where('public_uuid', $meetingUuid)->firstOrFail();
        
        $validated = $request->validate([
            'member_uuid' => 'required|string',
        ]);

        $member = Member::where('public_uuid', $validated['member_uuid'])->firstOrFail();

        // Create or update attendance
        $attendance = Attendance::firstOrCreate(
            ['meeting_id' => $meeting->id, 'member_id' => $member->id],
            ['status' => 'present', 'checked_in_at' => now()]
        );

        // If attendance already exists but updating
        if ($attendance->wasRecentlyCreated) {
            $message = "{$member->firstname} {$member->surname} checked in successfully!";
        } else {
            $attendance->update(['checked_in_at' => now(), 'status' => 'present']);
            $message = "{$member->firstname} {$member->surname} updated!";
        }

        // Assign seat if available
        if (!$attendance->seat_number && $meeting->total_seats) {
            $nextSeat = $meeting->getNextAvailableSeat();
            if ($nextSeat) {
                $attendance->assignSeat($nextSeat);
            }
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'member' => [
                'uuid' => $member->public_uuid,
                'name' => "{$member->firstname} {$member->surname}",
                'full_name' => $member->full_name,
                'firstname' => $member->firstname,
                'middlename' => $member->middlename,
                'surname' => $member->surname,
                'position' => $member->position,
                'phone' => $member->phone,
                'dob' => $member->dob?->format('M d, Y'),
                'state' => $member->state,
                'pscode' => $member->pscode,
                'category' => $member->category,
                'seat' => $attendance->seat_number,
                'image' => $member->image ? asset('storage/' . $member->image) : null,
                'checked_in_at' => $attendance->checked_in_at?->format('M d, Y H:i'),
            ],
            'meeting_attendance' => $meeting->attendances()->where('status', 'present')->count(),
        ]);
    }

    /**
     * Mark member as absent
     */
    public function markAbsent(Request $request, Meeting $meeting)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
        ]);

        $attendance = Attendance::firstOrCreate(
            ['meeting_id' => $meeting->id, 'member_id' => $validated['member_id']],
            ['status' => 'absent']
        );

        if (!$attendance->wasRecentlyCreated) {
            $attendance->update(['status' => 'absent', 'checked_in_at' => null, 'seat_number' => null]);
        }

        return redirect()->back()->with('success', 'Member marked as absent');
    }

    /**
     * Reassign seat
     */
    public function reassignSeat(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'seat_number' => 'required|integer|min:1',
        ]);

        // Check if seat is available
        $seatTaken = Attendance::where('meeting_id', $attendance->meeting_id)
            ->where('id', '!=', $attendance->id)
            ->where('seat_number', $validated['seat_number'])
            ->exists();

        if ($seatTaken) {
            return back()->with('error', 'Seat already taken');
        }

        $attendance->assignSeat($validated['seat_number']);

        return back()->with('success', 'Seat assigned successfully');
    }

    /**
     * Export attendance report
     */
    public function exportAttendance(Meeting $meeting)
    {
        $attendances = $meeting->attendances()
            ->with('member')
            ->orderBy('seat_number')
            ->get();

        $csv = "Seat,Name,Position,Status,Check-in Time\n";
        foreach ($attendances as $attendance) {
            $member = $attendance->member;
            $csv .= sprintf(
                "\"%s\",\"%s %s\",\"%s\",\"%s\",\"%s\"\n",
                $attendance->seat_number ?? '-',
                $member->firstname,
                $member->surname,
                $member->position,
                $attendance->status,
                $attendance->checked_in_at?->format('Y-m-d H:i:s') ?? '-'
            );
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $meeting->title . '_attendance.csv"');
    }
}
