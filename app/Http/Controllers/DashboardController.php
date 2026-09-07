<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Meeting;
use App\Models\Attendance;

class DashboardController extends Controller
{
    public function index()
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        // Real metrics
        $totalMembers = Member::count();
        $membersByCategory = Member::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->get()
            ->mapWithKeys(fn($m) => [$m->category => $m->total]);

        $totalMeetings = Meeting::count();
        $upcomingMeetings = Meeting::where('status', 'scheduled')
            ->where('scheduled_at', '>', now())
            ->count();
        $ongoingMeetings = Meeting::where('status', 'ongoing')->count();
        
        $totalAttendances = Attendance::count();
        $totalPresent = Attendance::where('status', 'present')->count();
        $attendanceRate = $totalAttendances > 0 ? round(($totalPresent / $totalAttendances) * 100) : 0;

        // Recent meetings
        $recentMeetings = Meeting::orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($meeting) {
                return [
                    'id' => $meeting->id,
                    'title' => $meeting->title,
                    'date' => $meeting->scheduled_at,
                    'status' => $meeting->status,
                    'attendees' => $meeting->attendances()->where('status', 'present')->count(),
                    'totalSeats' => $meeting->total_seats,
                ];
            });

        // Top attended meetings
        $topMeetings = Meeting::withCount(['attendances' => fn($q) => $q->where('status', 'present')])
            ->orderBy('attendances_count', 'desc')
            ->take(5)
            ->get();

        // Member distribution chart data
        $memberCategoryData = Member::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->get();

        return view('pages.dashboards.index', [
            'totalMembers' => $totalMembers,
            'membersByCategory' => $membersByCategory,
            'totalMeetings' => $totalMeetings,
            'upcomingMeetings' => $upcomingMeetings,
            'ongoingMeetings' => $ongoingMeetings,
            'totalAttendances' => $totalAttendances,
            'totalPresent' => $totalPresent,
            'attendanceRate' => $attendanceRate,
            'recentMeetings' => $recentMeetings,
            'topMeetings' => $topMeetings,
            'memberCategoryData' => $memberCategoryData,
        ]);
    }
}
