<x-default-layout>

    @section('title')
        Edit DEPs Member
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('members.deps.edit', $member) }}
    @endsection

    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <h2>Edit DEPs Member</h2>
            </div>
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            @include('pages.apps.members._form', [
                'isEdit' => true,
                'action' => route('members.deps.update', $member),
                'cancelUrl' => route('members.deps.index')
            ])
        </div>
        <!--end::Card body-->
    </div>

</x-default-layout>
