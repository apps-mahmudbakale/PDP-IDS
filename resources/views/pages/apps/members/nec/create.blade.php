<x-default-layout>

    @section('title')
        Add NEC Member
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('members.nec.create') }}
    @endsection

    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>Add New NEC Member</h2>
            </div>
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <form action="{{ route('members.nec.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-6">
                    <div class="col-md-6">
                        <label class="form-label">Title</label>
                        <select name="title" class="form-select @error('title') is-invalid @enderror">
                            <option value="">-- Select Title --</option>
                            @foreach(\App\Enums\MemberTitles::all() as $value => $label)
                                <option value="{{ $value }}" {{ old('title') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">First Name</label>
                        <input type="text" name="firstname" class="form-control @error('firstname') is-invalid @enderror" value="{{ old('firstname') }}" required>
                        @error('firstname')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-md-6">
                        <label class="form-label">Middle Name</label>
                        <input type="text" name="middlename" class="form-control @error('middlename') is-invalid @enderror" value="{{ old('middlename') }}">
                        @error('middlename')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Surname</label>
                        <input type="text" name="surname" class="form-control @error('surname') is-invalid @enderror" value="{{ old('surname') }}" required>
                        @error('surname')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-md-6">
                        <label class="form-label required">Position</label>
                        <input type="text" name="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position') }}" required>
                        @error('position')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                        @error('phone')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-md-6">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob') }}">
                        @error('dob')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">State</label>
                        <select name="state" class="form-select @error('state') is-invalid @enderror">
                            <option value="">-- Select State --</option>
                            @foreach(\App\Enums\NigerianStates::all() as $value => $label)
                                <option value="{{ $value }}" {{ old('state') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('state')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-md-6">
                        <label class="form-label">Postal Code</label>
                        <input type="text" name="pscode" class="form-control @error('pscode') is-invalid @enderror" value="{{ old('pscode') }}">
                        @error('pscode')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Photo</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        @error('image')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary">
                                {!! getIcon('check', 'fs-2', '', 'i') !!}
                                Save Member
                            </button>
                            <a href="{{ route('members.nec.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!--end::Card body-->
    </div>

</x-default-layout>
