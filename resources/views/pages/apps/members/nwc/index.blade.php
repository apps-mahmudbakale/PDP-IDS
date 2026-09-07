<x-default-layout>

    @section('title')
        NWC Members
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('members.nwc.index') }}
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
                    <input type="text" id="searchInput" class="form-control form-control-solid w-250px ps-13" placeholder="Search NWC member" />
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end">
                    <!--begin::Add member-->
                    <a href="{{ route('members.nwc.create') }}" class="btn btn-primary">
                        {!! getIcon('plus', 'fs-2', '', 'i') !!}
                        Add NWC Member
                    </a>
                    <!--end::Add member-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            @if($members->count())
                <!--begin::Table-->
                <div class="table-responsive">
                    <table class="table table-row-bordered table-row-hover gy-4 gs-7">
                        <thead>
                            <tr class="fw-semibold fs-6 text-gray-800 px-4">
                                <th>Name</th>
                                <th>Position</th>
                                <th>Phone</th>
                                <th>State</th>
                                <th>DOB</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $member)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($member->image)
                                                <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->firstname }}" class="w-40px h-40px rounded-circle me-3">
                                            @else
                                                <div class="w-40px h-40px rounded-circle bg-light-info me-3 d-flex align-items-center justify-content-center">
                                                    <span class="fs-7 fw-bold">{{ substr($member->firstname, 0, 1) }}{{ substr($member->surname, 0, 1) }}</span>
                                                </div>
                                            @endif
                                            <div class="d-flex flex-column">
                                                <a href="{{ route('members.nwc.show', $member) }}" class="text-gray-800 text-hover-primary">
                                                    {{ $member->firstname }} {{ $member->middlename }} {{ $member->surname }}
                                                </a>
                                                @if($member->title)
                                                    <span class="text-muted fs-7">{{ $member->title }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $member->position }}</td>
                                    <td>{{ $member->phone ?? 'N/A' }}</td>
                                    <td>{{ $member->state ?? 'N/A' }}</td>
                                    <td>{{ $member->dob?->format('Y-m-d') ?? 'N/A' }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('members.nwc.edit', $member) }}" class="btn btn-sm btn-icon btn-light-warning me-2" title="Edit">
                                                {!! getIcon('pencil', 'fs-5') !!}
                                            </a>
                                            <form action="{{ route('members.nwc.destroy', $member) }}" method="POST" style="display: inline;">
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
            @else
                <div class="text-center py-10">
                    <div class="mb-3">
                        {!! getIcon('magnifier', 'fs-2tx text-muted') !!}
                    </div>
                    <p class="text-muted">No NWC members found</p>
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

