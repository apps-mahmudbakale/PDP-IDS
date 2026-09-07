<x-default-layout>

    @section('title')
        {{ $meeting->title }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('meetings.show', $meeting) }}
    @endsection

    <div class="row mb-6">
        <div class="col-lg-8">
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h2>Meeting Details</h2>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('meetings.edit', $meeting) }}" class="btn btn-primary">
                            {!! getIcon('pencil', 'fs-2', '', 'i') !!}
                            Edit
                        </a>
                    </div>
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-muted fs-7 fw-bold w-200px">Title</td>
                                    <td class="fw-bold">{{ $meeting->title }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fs-7 fw-bold">Date & Time</td>
                                    <td class="fw-bold">{{ $meeting->scheduled_at->format('M d, Y @ H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fs-7 fw-bold">Location</td>
                                    <td class="fw-bold">{{ $meeting->location ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fs-7 fw-bold">Description</td>
                                    <td class="fw-bold">{{ $meeting->description ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fs-7 fw-bold">Total Seats</td>
                                    <td class="fw-bold">
                                        @if($meeting->total_seats)
                                            {{ $meeting->total_seats }}
                                        @else
                                            Unlimited
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted fs-7 fw-bold">Status</td>
                                    <td class="fw-bold">
                                        @if($meeting->status === 'scheduled')
                                            <span class="badge bg-light-warning">Scheduled</span>
                                        @elseif($meeting->status === 'ongoing')
                                            <span class="badge bg-light-success">Ongoing</span>
                                        @else
                                            <span class="badge bg-light-secondary">Completed</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted fs-7 fw-bold">Members Present</td>
                                    <td class="fw-bold">
                                        <span class="badge bg-light-info fs-7 px-3 py-2">
                                            {{ $meeting->attendances()->where('status', 'present')->count() }}
                                            @if($meeting->total_seats)
                                                / {{ $meeting->total_seats }}
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted fs-7 fw-bold">Created</td>
                                    <td class="fw-bold">{{ $meeting->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end::Card body-->
            </div>

            <!-- Attendances List -->
            <div class="card mt-6">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h2>Attendance</h2>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('attendance.export', $meeting) }}" class="btn btn-light-info">
                            {!! getIcon('cloud-download', 'fs-2', '', 'i') !!}
                            Export CSV
                        </a>
                    </div>
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body py-4">
                    @if($attendances->count())
                        <!--begin::Table-->
                        <div class="table-responsive">
                            <table class="table table-row-bordered table-row-hover gy-4 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800 px-4">
                                        <th>Seat</th>
                                        <th>Member Name</th>
                                        <th>Position</th>
                                        <th>Check-in Time</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendances as $attendance)
                                        <tr>
                                            <td class="fw-bold">
                                                @if($attendance->seat_number)
                                                    #{{ $attendance->seat_number }}
                                                @else
                                                    <span class="badge bg-light-secondary">Unassigned</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($attendance->member->image)
                                                        <img src="{{ asset('storage/' . $attendance->member->image) }}" alt="{{ $attendance->member->firstname }}" class="w-40px h-40px rounded-circle me-3">
                                                    @else
                                                        <div class="w-40px h-40px rounded-circle bg-light-info me-3 d-flex align-items-center justify-content-center">
                                                            <span class="fs-7 fw-bold">{{ substr($attendance->member->firstname, 0, 1) }}{{ substr($attendance->member->surname, 0, 1) }}</span>
                                                        </div>
                                                    @endif
                                                    <div class="d-flex flex-column">
                                                        <a href="{{ route('members.public-profile', $attendance->member->public_uuid) }}" class="text-gray-800 text-hover-primary">
                                                            {{ $attendance->member->firstname }} {{ $attendance->member->surname }}
                                                        </a>
                                                        @if($attendance->member->title)
                                                            <span class="text-muted fs-7">{{ $attendance->member->title }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $attendance->member->position }}</td>
                                            <td>
                                                @if($attendance->checked_in_at)
                                                    <span class="fw-bold">{{ $attendance->checked_in_at->format('H:i:s') }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($attendance->status === 'present')
                                                    <span class="badge bg-light-success">Present</span>
                                                @elseif($attendance->status === 'late')
                                                    <span class="badge bg-light-warning">Late</span>
                                                @else
                                                    <span class="badge bg-light-danger">Absent</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <form action="{{ route('attendance.reassign-seat', $attendance) }}" method="POST" style="display: inline;" onsubmit="return assignSeat(event, {{ $meeting->total_seats ?? 0 }})">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="seat_number" id="seat-{{ $attendance->id }}">
                                                        <button type="submit" class="btn btn-sm btn-icon btn-light-info" title="Reassign Seat" @if(!$meeting->total_seats) disabled @endif>
                                                            {!! getIcon('chair', 'fs-5') !!}
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--end::Table-->
                    @else
                        <div class="text-center py-10">
                            <div class="mb-3">
                                {!! getIcon('people', 'fs-2tx text-muted') !!}
                            </div>
                            <p class="text-muted">No attendances recorded yet</p>
                        </div>
                    @endif
                </div>
                <!--end::Card body-->
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h5>QR Code for Attendance</h5>
                    </div>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $meeting->getAttendanceQrUrl() }}" alt="Attendance QR Code" class="img-fluid" style="max-width: 100%; height: auto;">
                    <p class="text-muted fs-7 mt-3">Scan to mark attendance for this meeting</p>
                    <a href="{{ route('meetings.attendance-scan', $meeting->public_uuid) }}" class="btn btn-sm btn-primary w-100 mt-3">
                        {!! getIcon('qrcode', 'fs-4', '', 'i') !!}
                        Open Scanner
                    </a>
                </div>
            </div>

            <div class="card mt-6">
                <div class="card-body">
                    <form action="{{ route('meetings.destroy', $meeting) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this meeting?')">
                            {!! getIcon('trash', 'fs-2', '', 'i') !!}
                            Delete Meeting
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function assignSeat(event, totalSeats) {
                event.preventDefault();
                if (totalSeats === 0) {
                    alert('This meeting has unlimited seats');
                    return false;
                }
                const seatNumber = prompt('Enter seat number (1-' + totalSeats + '):');
                if (seatNumber && seatNumber > 0 && seatNumber <= totalSeats) {
                    document.getElementById('seat-' + event.target.closest('form').action.split('/').pop()).value = seatNumber;
                    event.target.closest('form').submit();
                } else {
                    alert('Invalid seat number');
                }
                return false;
            }
        </script>
    @endpush

</x-default-layout>
