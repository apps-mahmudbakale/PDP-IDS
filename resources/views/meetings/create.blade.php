<x-default-layout>

    @section('title')
        Add Meeting
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('meetings.create') }}
    @endsection

    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>Add New Meeting</h2>
            </div>
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <form action="{{ route('meetings.store') }}" method="POST">
                @csrf

                <div class="row mb-6">
                    <div class="col-md-12">
                        <label class="form-label required">Meeting Title</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Enter meeting title" required>
                        @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="Enter meeting description">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-md-6">
                        <label class="form-label required">Date & Time</label>
                        <input type="datetime-local" name="scheduled_at" class="form-control @error('scheduled_at') is-invalid @enderror" value="{{ old('scheduled_at') }}" required>
                        @error('scheduled_at')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}" placeholder="Enter meeting location">
                        @error('location')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-md-6">
                        <label class="form-label">Total Seats</label>
                        <input type="number" name="total_seats" class="form-control @error('total_seats') is-invalid @enderror" value="{{ old('total_seats') }}" placeholder="Enter total number of seats" min="1">
                        @error('total_seats')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary">
                                {!! getIcon('check', 'fs-2', '', 'i') !!}
                                Save Meeting
                            </button>
                            <a href="{{ route('meetings.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!--end::Card body-->
    </div>

</x-default-layout>
