<x-default-layout>

    @section('title')
        Dashboard
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection

    <!-- Statistics Cards Row -->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!-- Total Members -->
        <div class="col-md-6 col-lg-3">
            <div class="card bg-white border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Total Members</p>
                            <h3 class="mb-0" style="font-size: 32px; font-weight: 700; color: #202124;">{{ $totalMembers }}</h3>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(26, 115, 232, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #1a73e8;">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    @if($membersByCategory->count())
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-muted">By Category:</small>
                        <div class="mt-2">
                            @foreach($membersByCategory as $category => $count)
                            <span class="badge bg-light" style="color: #5f6368; margin-bottom: 4px;">
                                {{ $category }}: <strong>{{ $count }}</strong>
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Total Meetings -->
        <div class="col-md-6 col-lg-3">
            <div class="card bg-white border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Total Meetings</p>
                            <h3 class="mb-0" style="font-size: 32px; font-weight: 700; color: #202124;">{{ $totalMeetings }}</h3>
                            <small class="text-muted mt-2 d-block">
                                <i class="fas fa-circle" style="font-size: 8px; color: #185abc;"></i> {{ $ongoingMeetings }} Ongoing
                                <i class="fas fa-circle" style="font-size: 8px; color: #fa7b17; margin-left: 8px;"></i> {{ $upcomingMeetings }} Upcoming
                            </small>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(24, 90, 188, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #185abc;">
                            <i class="fas fa-calendar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Rate -->
        <div class="col-md-6 col-lg-3">
            <div class="card bg-white border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Attendance Rate</p>
                            <h3 class="mb-0" style="font-size: 32px; font-weight: 700; color: #202124;">{{ $attendanceRate }}%</h3>
                            <small class="text-muted mt-2 d-block">{{ $totalPresent }} of {{ $totalAttendances }} attended</small>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(52, 168, 83, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #34a853;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <div style="height: 4px; background: #e0e0e0; border-radius: 2px; overflow: hidden;">
                            <div style="height: 100%; background: #34a853; width: {{ $attendanceRate }}%; transition: width 0.3s ease;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Attendances -->
        <div class="col-md-6 col-lg-3">
            <div class="card bg-white border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Total Check-ins</p>
                            <h3 class="mb-0" style="font-size: 32px; font-weight: 700; color: #202124;">{{ $totalAttendances }}</h3>
                            <small class="text-muted mt-2 d-block">Across all meetings</small>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(250, 123, 23, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #fa7b17;">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Meetings & Top Meetings -->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!-- Recent Meetings -->
        <div class="col-xl-6">
            <div class="card bg-white border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 p-4">
                    <h5 class="mb-0" style="font-weight: 600; color: #202124;">Recent Meetings</h5>
                </div>
                <div class="card-body p-4 pt-0">
                    @if($recentMeetings->count())
                    <div class="timeline timeline-border-left">
                        @foreach($recentMeetings as $meeting)
                        <div class="timeline-item mb-3 pb-3 border-bottom last:border-bottom-0 last:mb-0 last:pb-0">
                            <div class="timeline-line"></div>
                            <div class="d-flex gap-3">
                                <div style="flex-shrink: 0;">
                                    <div style="width: 36px; height: 36px; background: 
                                        @if($meeting['status'] === 'ongoing') rgba(52, 168, 83, 0.1)
                                        @elseif($meeting['status'] === 'scheduled') rgba(250, 123, 23, 0.1)
                                        @else rgba(95, 99, 104, 0.1)
                                        @endif; 
                                        border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px;
                                        color: @if($meeting['status'] === 'ongoing') #34a853
                                        @elseif($meeting['status'] === 'scheduled') #fa7b17
                                        @else #5f6368
                                        @endif">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                </div>
                                <div style="flex: 1;">
                                    <h6 class="mb-1" style="font-weight: 600; color: #202124;">{{ $meeting['title'] }}</h6>
                                    <p class="mb-1" style="font-size: 12px; color: #5f6368;">
                                        <i class="fas fa-clock"></i> {{ $meeting['date']->format('M d, Y H:i') }}
                                    </p>
                                    <p class="mb-0" style="font-size: 12px; color: #5f6368;">
                                        <i class="fas fa-users"></i> {{ $meeting['attendees'] }} attendee@if($meeting['attendees'] !== 1)s@endif
                                        @if($meeting['totalSeats'])
                                        / {{ $meeting['totalSeats'] }} seats
                                        @endif
                                    </p>
                                    <span style="display: inline-block; margin-top: 6px;" class="badge 
                                        @if($meeting['status'] === 'ongoing') bg-light-success
                                        @elseif($meeting['status'] === 'scheduled') bg-light-warning
                                        @else bg-light-secondary
                                        @endif">
                                        {{ ucfirst($meeting['status']) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times" style="font-size: 32px; color: #e0e0e0; margin-bottom: 10px; display: block;"></i>
                        <p class="text-muted">No meetings yet</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Attended Meetings -->
        <div class="col-xl-6">
            <div class="card bg-white border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 p-4">
                    <h5 class="mb-0" style="font-weight: 600; color: #202124;">Top Attended Meetings</h5>
                </div>
                <div class="card-body p-4 pt-0">
                    @if($topMeetings->count())
                    @foreach($topMeetings as $index => $meeting)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; @if(!$loop->last)border-bottom: 1px solid #e0e0e0;@endif">
                        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #1a73e8, #185abc); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px;">
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <h6 class="mb-1" style="font-weight: 600; color: #202124; font-size: 13px;">{{ $meeting->title }}</h6>
                                <p class="mb-0" style="font-size: 12px; color: #5f6368;">{{ $meeting->scheduled_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <span style="display: inline-block; background: #f0f4ff; color: #1a73e8; padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 13px;">
                                {{ $meeting->attendances_count }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-chart-bar" style="font-size: 32px; color: #e0e0e0; margin-bottom: 10px; display: block;"></i>
                        <p class="text-muted">No attendance data yet</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-5 g-xl-10">
        <div class="col-12">
            <div class="card bg-white border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 p-4">
                    <h5 class="mb-0" style="font-weight: 600; color: #202124;">Quick Actions</h5>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('meetings.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create New Meeting
                        </a>
                        <a href="{{ route('meetings.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list"></i> View All Meetings
                        </a>
                        <a href="{{ route('members.nwc.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-users"></i> Manage Members
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-default-layout>
