<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    /**
     * Display a listing of meetings
     */
    public function index()
    {
        $meetings = Meeting::orderBy('scheduled_at', 'desc')->paginate(15);
        return view('meetings.index', compact('meetings'));
    }

    /**
     * Show the form for creating a new meeting
     */
    public function create()
    {
        return view('meetings.create');
    }

    /**
     * Store a newly created meeting
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'scheduled_at' => 'required|date_format:Y-m-d\TH:i',
            'location' => 'nullable|string|max:200',
            'total_seats' => 'nullable|integer|min:1',
        ]);

        Meeting::create($validated);

        return redirect()->route('meetings.index')
            ->with('success', 'Meeting created successfully');
    }

    /**
     * Display the specified meeting
     */
    public function show(Meeting $meeting)
    {
        $attendances = $meeting->attendances()
            ->with('member')
            ->orderBy('seat_number')
            ->get();

        return view('meetings.show', compact('meeting', 'attendances'));
    }

    /**
     * Show the form for editing
     */
    public function edit(Meeting $meeting)
    {
        return view('meetings.edit', compact('meeting'));
    }

    /**
     * Update the specified meeting
     */
    public function update(Request $request, Meeting $meeting)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'scheduled_at' => 'required|date_format:Y-m-d\TH:i',
            'location' => 'nullable|string|max:200',
            'total_seats' => 'nullable|integer|min:1',
            'status' => 'required|in:scheduled,ongoing,completed',
        ]);

        $meeting->update($validated);

        return redirect()->route('meetings.show', $meeting)
            ->with('success', 'Meeting updated successfully');
    }

    /**
     * Delete the specified meeting
     */
    public function destroy(Meeting $meeting)
    {
        $meeting->delete();

        return redirect()->route('meetings.index')
            ->with('success', 'Meeting deleted successfully');
    }
}
