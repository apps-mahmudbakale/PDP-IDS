<x-default-layout>

    @section('title')
        {{ $member->firstname }} {{ $member->surname }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('members.nwc.show', $member) }}
    @endsection

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h2>Member Details</h2>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('members.nwc.edit', $member) }}" class="btn btn-primary">
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
                                    <td class="text-muted fs-7 fw-bold w-200px">First Name</td>
                                    <td class="fw-bold">{{ $member->firstname }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fs-7 fw-bold">Middle Name</td>
                                    <td class="fw-bold">{{ $member->middlename ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fs-7 fw-bold">Surname</td>
                                    <td class="fw-bold">{{ $member->surname }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fs-7 fw-bold">Title</td>
                                    <td class="fw-bold">{{ $member->title ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fs-7 fw-bold">Position</td>
                                    <td class="fw-bold">{{ $member->position }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fs-7 fw-bold">Phone</td>
                                    <td class="fw-bold">{{ $member->phone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fs-7 fw-bold">Date of Birth</td>
                                    <td class="fw-bold">{{ $member->dob?->format('M d, Y') ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fs-7 fw-bold">State</td>
                                    <td class="fw-bold">{{ $member->state ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fs-7 fw-bold">Postal Code</td>
                                    <td class="fw-bold">{{ $member->pscode ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fs-7 fw-bold">Category</td>
                                    <td class="fw-bold">
                                        <span class="badge bg-light-info">{{ $member->category }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted fs-7 fw-bold">Created</td>
                                    <td class="fw-bold">{{ $member->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
        </div>

        <div class="col-lg-4">
            @if($member->image)
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->firstname }}" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h5>QR Code</h5>
                    </div>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $member->getQrCodeUrl() }}" alt="QR Code" class="img-fluid" style="max-width: 100%; height: auto;">
                    <p class="text-muted fs-7 mt-3">Scan to view member profile</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('members.nwc.destroy', $member) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this member?')">
                            {!! getIcon('trash', 'fs-2', '', 'i') !!}
                            Delete Member
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-default-layout>
