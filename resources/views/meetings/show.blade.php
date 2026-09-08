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
                                                    <button type="button" class="btn btn-sm btn-icon btn-light-info" title="Reassign Seat" @if(!$meeting->total_seats) disabled @endif onclick="openSeatModal({{ $attendance->id }}, '{{ $attendance->member->firstname }} {{ $attendance->member->surname }}', {{ $attendance->seat_number ?? 'null' }}, {{ $meeting->total_seats ?? 0 }})">
                                                        {!! getIcon('chair', 'fs-5') !!}
                                                    </button>
                                                    @if($attendance->seat_number)
                                                    <button type="button" class="btn btn-sm btn-icon btn-light-success" title="Print Seat Ticket" onclick="printSeatTicket({{ $attendance->id }}, '{{ $attendance->member->firstname }} {{ $attendance->member->surname }}', {{ $attendance->seat_number }}, '{{ $meeting->title }}')">
                                                        {!! getIcon('printer', 'fs-5') !!}
                                                    </button>
                                                    @endif
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
            // Seat Assignment Modal
            function openSeatModal(attendanceId, memberName, currentSeat, totalSeats) {
                const modal = document.getElementById('seatModal');
                document.getElementById('modalTitle').textContent = `Assign Seat to ${memberName}`;
                document.getElementById('currentSeatInfo').textContent = currentSeat ? `Current: Seat #${currentSeat}` : 'Not assigned yet';
                document.getElementById('seatInput').value = currentSeat || '';
                document.getElementById('seatInput').max = totalSeats;
                document.getElementById('seatInput').setAttribute('data-attendance-id', attendanceId);
                document.getElementById('seatInput').setAttribute('data-total-seats', totalSeats);
                modal.style.display = 'block';
                document.getElementById('seatInput').focus();
            }

            function closeSeatModal() {
                document.getElementById('seatModal').style.display = 'none';
            }

            function submitSeatAssignment() {
                const seatInput = document.getElementById('seatInput');
                const attendanceId = seatInput.getAttribute('data-attendance-id');
                const totalSeats = seatInput.getAttribute('data-total-seats');
                const seatNumber = parseInt(seatInput.value);

                if (!seatNumber || seatNumber < 1 || seatNumber > totalSeats) {
                    alert(`Please enter a valid seat number (1-${totalSeats})`);
                    return;
                }

                // Create and submit form
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/attendance/${attendanceId}/reassign-seat`;
                form.innerHTML = `
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="seat_number" value="${seatNumber}">
                `;
                document.body.appendChild(form);
                form.submit();
            }

            function printSeatTicket(attendanceId, memberName, seatNumber, meetingTitle) {
                const printWindow = window.open('', '', 'height=600,width=800');
                const html = `
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Seat Ticket - ${memberName}</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                margin: 0;
                                padding: 20px;
                                background: #f5f5f5;
                            }
                            .ticket {
                                width: 400px;
                                margin: 20px auto;
                                background: white;
                                border: 3px solid #1a73e8;
                                border-radius: 12px;
                                padding: 30px;
                                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                                text-align: center;
                            }
                            .header {
                                border-bottom: 2px solid #f0f0f0;
                                padding-bottom: 15px;
                                margin-bottom: 20px;
                            }
                            .meeting-title {
                                font-size: 18px;
                                color: #1a73e8;
                                font-weight: 700;
                                margin-bottom: 10px;
                            }
                            .ticket-type {
                                font-size: 12px;
                                color: #5f6368;
                                text-transform: uppercase;
                                letter-spacing: 1px;
                                font-weight: 600;
                            }
                            .member-name {
                                font-size: 24px;
                                font-weight: 700;
                                color: #202124;
                                margin: 20px 0;
                            }
                            .seat-section {
                                background: linear-gradient(135deg, #1a73e8 0%, #185abc 100%);
                                color: white;
                                padding: 30px;
                                border-radius: 8px;
                                margin: 20px 0;
                            }
                            .seat-label {
                                font-size: 12px;
                                text-transform: uppercase;
                                letter-spacing: 1px;
                                opacity: 0.9;
                                margin-bottom: 10px;
                                font-weight: 600;
                            }
                            .seat-number {
                                font-size: 72px;
                                font-weight: 700;
                                line-height: 1;
                            }
                            .footer {
                                border-top: 2px solid #f0f0f0;
                                padding-top: 15px;
                                margin-top: 20px;
                                font-size: 11px;
                                color: #5f6368;
                            }
                            .barcode-area {
                                margin: 20px 0;
                                padding: 15px;
                                background: #f8f9fa;
                                border-radius: 6px;
                            }
                            .barcode-text {
                                font-size: 10px;
                                letter-spacing: 2px;
                                font-family: monospace;
                                color: #202124;
                            }
                            @media print {
                                body {
                                    background: white;
                                }
                                .ticket {
                                    margin: 0;
                                    box-shadow: none;
                                }
                            }
                        </style>
                    </head>
                    <body>
                        <div class="ticket">
                            <div class="header">
                                <div class="ticket-type">🎟️ Seat Ticket</div>
                                <div class="meeting-title">${meetingTitle}</div>
                            </div>
                            <div class="member-name">${memberName}</div>
                            <div class="seat-section">
                                <div class="seat-label">Your Seat</div>
                                <div class="seat-number">#${seatNumber}</div>
                            </div>
                            <div class="barcode-area">
                                <div class="barcode-text">SEAT-${seatNumber}-${attendanceId.toString().padStart(6, '0')}</div>
                            </div>
                            <div class="footer">
                                <p>Please keep this ticket safe. Present it upon entry.</p>
                                <p>Printed: ${new Date().toLocaleString()}</p>
                            </div>
                        </div>
                        <script>
                            window.print();
                        </script>
                    </body>
                    </html>
                `;
                printWindow.document.write(html);
                printWindow.document.close();
            }

            // Close modal on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeSeatModal();
                }
            });

            // Close modal when clicking outside
            window.onclick = function(event) {
                const modal = document.getElementById('seatModal');
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
        </script>
    @endpush

    <!-- Seat Assignment Modal -->
    <div id="seatModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
        <div style="background-color: white; margin: 100px auto; padding: 0; border-radius: 8px; width: 90%; max-width: 400px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
            <div style="padding: 20px; border-bottom: 1px solid #e0e0e0; display: flex; justify-content: space-between; align-items: center;">
                <h3 id="modalTitle" style="margin: 0; font-size: 18px; font-weight: 600; color: #202124;">Assign Seat</h3>
                <button onclick="closeSeatModal()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #5f6368;">&times;</button>
            </div>
            <div style="padding: 30px;">
                <div id="currentSeatInfo" style="font-size: 13px; color: #5f6368; margin-bottom: 20px; padding: 10px; background: #f8f9fa; border-radius: 6px;"></div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #5f6368; text-transform: uppercase; margin-bottom: 10px;">Enter Seat Number</label>
                    <input type="number" id="seatInput" min="1" max="100" placeholder="e.g., 5" style="width: 100%; padding: 12px; border: 1px solid #d0d5dd; border-radius: 6px; font-size: 14px; box-sizing: border-box;" onkeypress="if(event.key==='Enter') submitSeatAssignment()">
                </div>
            </div>
            <div style="padding: 20px; border-top: 1px solid #e0e0e0; display: flex; gap: 10px; justify-content: flex-end;">
                <button onclick="closeSeatModal()" style="padding: 10px 20px; background: #f0f0f0; color: #202124; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">Cancel</button>
                <button onclick="submitSeatAssignment()" style="padding: 10px 20px; background: #1a73e8; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">Assign Seat</button>
            </div>
        </div>
    </div>

</x-default-layout>
