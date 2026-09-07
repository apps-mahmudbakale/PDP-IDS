<x-default-layout>

    @section('title')
        Meetings
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('meetings.index') }}
    @endsection

    @if($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" id="searchInput" class="form-control form-control-solid w-250px ps-13" placeholder="Search meetings" />
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end">
                    <!--begin::Add meeting-->
                    <a href="{{ route('meetings.create') }}" class="btn btn-primary">
                        {!! getIcon('plus', 'fs-2', '', 'i') !!}
                        Add Meeting
                    </a>
                    <!--end::Add meeting-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            @if($meetings->count())
                <!--begin::Table-->
                <div class="table-responsive">
                    <table class="table table-row-bordered table-row-hover gy-4 gs-7">
                        <thead>
                            <tr class="fw-semibold fs-6 text-gray-800 px-4">
                                <th>Title</th>
                                <th>Date & Time</th>
                                <th>Location</th>
                                <th>Attendees</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($meetings as $meeting)
                                <tr>
                                    <td>
                                        <a href="{{ route('meetings.show', $meeting) }}" class="text-gray-800 text-hover-primary fw-bold">
                                            {{ $meeting->title }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold">{{ $meeting->scheduled_at->format('M d, Y') }}</span>
                                            <span class="text-muted fs-7">{{ $meeting->scheduled_at->format('H:i') }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $meeting->location ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-light-info">
                                            {{ $meeting->attendances()->where('status', 'present')->count() }}
                                            @if($meeting->total_seats)
                                                / {{ $meeting->total_seats }}
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        @if($meeting->status === 'scheduled')
                                            <span class="badge bg-light-warning">Scheduled</span>
                                        @elseif($meeting->status === 'ongoing')
                                            <span class="badge bg-light-success">Ongoing</span>
                                        @else
                                            <span class="badge bg-light-secondary">Completed</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('meetings.show', $meeting) }}" class="btn btn-sm btn-icon btn-light-info" title="View Details">
                                                {!! getIcon('eye', 'fs-5') !!}
                                            </a>
                                            <a href="{{ route('meetings.edit', $meeting) }}" class="btn btn-sm btn-icon btn-light-warning" title="Edit">
                                                {!! getIcon('pencil', 'fs-5') !!}
                                            </a>
                                            <form action="{{ route('meetings.destroy', $meeting) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-icon btn-light-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                                    {!! getIcon('trash', 'fs-5') !!}
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

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $meetings->links() }}
                </div>
            @else
                <div class="text-center py-10">
                    <div class="mb-3">
                        {!! getIcon('magnifier', 'fs-2tx text-muted') !!}
                    </div>
                    <p class="text-muted">No meetings found</p>
                </div>
            @endif
        </div>
        <!--end::Card body-->
    </div>

    @push('scripts')
        <script>
            document.getElementById('searchInput').addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('table tbody tr');
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });
        </script>
    @endpush

</x-default-layout>
