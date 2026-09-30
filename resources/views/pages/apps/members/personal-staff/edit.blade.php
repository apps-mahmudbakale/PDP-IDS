<x-default-layout>

    @section('title')
        Edit Personal Staff Member
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('members.personal-staff.edit', $member) }}
    @endsection

    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>Edit Personal Staff Member</h2>
            </div>
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            @include('pages.apps.members._form', [
                'withDepartment' => true,
                'isEdit' => true,
                'action' => route('members.personal-staff.update', $member),
                'cancelUrl' => route('members.personal-staff.index')
            ])
        </div>
        <!--end::Card body-->
    </div>

</x-default-layout>
