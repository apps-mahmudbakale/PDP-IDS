<x-default-layout>
    <div class="d-flex flex-column flex-root">
        <!--begin::Main-->
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <!--begin::Content wrapper-->
            <div class="d-flex flex-column flex-column-fluid">
                <!--begin::Toolbar-->
                <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                    <!--begin::Toolbar container-->
                    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                        <!--begin::Page title-->
                        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                            <!--begin::Title-->
                            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                                Member Profile
                            </h1>
                            <!--end::Title-->
                            <!--begin::Breadcrumb-->
                            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-muted">
                                    <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item">
                                    <span class="bullet bg-gray-500 w-5px h-2px"></span>
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="breadcrumb-item text-muted">Member Profile</li>
                                <!--end::Item-->
                            </ul>
                            <!--end::Breadcrumb-->
                        </div>
                        <!--end::Page title-->
                    </div>
                    <!--end::Toolbar container-->
                </div>
                <!--end::Toolbar-->

                <!--begin::Content-->
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <!--begin::Content container-->
                    <div id="kt_app_content_container" class="app-container container-xxl">
                        <!--begin::Member Profile Image Card-->
                        <div class="row gx-9 gy-6 mb-6">
                            <div class="col-12">
                                <div class="card" style="background: #f8f9fa; border: none; box-shadow: 0 1px 3px rgba(32, 33, 36, 0.08); overflow: hidden;">
                                    <div class="card-body p-0">
                                        <div style="display: flex; align-items: center; gap: 30px; padding: 40px;">
                                            <!--begin::Profile Image-->
                                            <div style="flex-shrink: 0;">
                                                @if($member->image)
                                                    <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->firstname }}" style="width: 180px; height: 180px; border-radius: 12px; object-fit: cover; box-shadow: 0 4px 12px rgba(32, 33, 36, 0.15); border: 4px solid white;" />
                                                @else
                                                    <div style="width: 180px; height: 180px; border-radius: 12px; background: linear-gradient(135deg, #1a73e8 0%, #185abc 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 64px; font-weight: 700; box-shadow: 0 4px 12px rgba(32, 33, 36, 0.15); border: 4px solid white;">
                                                        {{ substr($member->firstname, 0, 1) }}{{ substr($member->surname, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <!--end::Profile Image-->
                                            <!--begin::Member Info-->
                                            <div style="flex: 1;">
                                                <h2 style="font-size: 28px; font-weight: 700; color: #202124; margin-bottom: 8px;">
                                                    @if($member->title)
                                                        {{ $member->title }}
                                                    @endif
                                                    {{ $member->firstname }} {{ $member->surname }}
                                                </h2>
                                                @if($member->position)
                                                    <p style="font-size: 16px; color: #5f6368; margin-bottom: 16px; font-weight: 500;">
                                                        <i class="fas fa-briefcase" style="margin-right: 8px; color: #1a73e8;"></i>{{ $member->position }}
                                                    </p>
                                                @endif
                                                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                                                    <span class="badge" style="background: rgba(24, 90, 188, 0.1); color: #185abc; padding: 8px 14px; border-radius: 6px; font-size: 13px; font-weight: 600;">
                                                        <i class="fas fa-id-badge me-1"></i>{{ strtoupper($member->category) }}
                                                    </span>
                                                    @if($member->seat)
                                                        <span class="badge" style="background: rgba(26, 115, 232, 0.1); color: #1a73e8; padding: 8px 14px; border-radius: 6px; font-size: 13px; font-weight: 600;">
                                                            <i class="fas fa-chair me-1"></i>Seat: {{ $member->seat }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <!--end::Member Info-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Member Profile Image Card-->

                        <div class="row gx-9 gy-6">
                            <!--begin::Sidebar-->
                            <div class="col-xxl-3">
                                <!--begin::Sidebar Widget 1-->
                                <div class="card mb-6" style="background: #f8f9fa; border: none; box-shadow: 0 1px 3px rgba(32, 33, 36, 0.08);">
                                    <!--begin::Body-->
                                    <div class="card-body pt-9 pb-0">
                                        <!--begin::Summary-->
                                        <div class="d-flex flex-center flex-column">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-100px mb-6">
                                                @if($member->image)
                                                    <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->firstname }}" />
                                                @else
                                                    <div class="symbol-label fs-3 bg-light-info text-info">
                                                        {{ substr($member->firstname, 0, 1) }}{{ substr($member->surname, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Name-->
                                            <a href="#" class="text-gray-900 text-hover-primary fs-3 fw-bold mb-3" style="color: #202124;">
                                                @if($member->title)
                                                    {{ $member->title }}
                                                @endif
                                                {{ $member->firstname }} {{ $member->surname }}
                                            </a>
                                            <!--end::Name-->
                                            <!--begin::Position-->
                                            @if($member->position)
                                                <div class="mb-6 text-center">
                                                    <div class="badge" style="background: rgba(26, 115, 232, 0.1); color: #1a73e8;">{{ $member->position }}</div>
                                                </div>
                                            @endif
                                            <!--end::Position-->
                                            <!--begin::Info-->
                                            <div class="text-center pb-5">
                                                <div class="fs-5 fw-semibold mb-2">
                                                    <span class="badge" style="background: rgba(24, 90, 188, 0.1); color: #185abc;">{{ strtoupper($member->category) }}</span>
                                                </div>
                                                @if($member->seat)
                                                    <div style="color: #5f6368; font-size: 14px; font-weight: 500;">Seat: {{ $member->seat }}</div>
                                                @endif
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::Summary-->
                                        <!--begin::Details-->
                                        <div class="d-flex flex-stack pb-6">
                                            <div class="text-center">
                                                <div style="font-weight: 700; font-size: 24px; color: #202124;">{{ $member->category }}</div>
                                                <div style="color: #5f6368; font-size: 12px; font-weight: 600; text-transform: uppercase;">Category</div>
                                            </div>
                                            <div class="text-center">
                                                <div style="font-weight: 700; font-size: 24px; color: #202124;">{{ $member->seat ?? 'N/A' }}</div>
                                                <div style="color: #5f6368; font-size: 12px; font-weight: 600; text-transform: uppercase;">Seat</div>
                                            </div>
                                        </div>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Sidebar Widget 1-->

                                <!--begin::Sidebar Widget 2-->
                                <div class="card" style="background: #f8f9fa; border: none; box-shadow: 0 1px 3px rgba(32, 33, 36, 0.08);">
                                    <!--begin::Body-->
                                    <div class="card-body pt-6">
                                        <!--begin::Item-->
                                        <div class="d-flex mb-8">
                                            <!--begin::Icon-->
                                            <div class="me-4">
                                                <div style="width: 40px; height: 40px; background: rgba(26, 115, 232, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #1a73e8; font-size: 18px;">
                                                    <i class="fas fa-briefcase"></i>
                                                </div>
                                            </div>
                                            <!--end::Icon-->
                                            <!--begin::Info-->
                                            <div class="flex-grow-1">
                                                <a href="#" class="text-gray-900 text-hover-primary fw-bold fs-6" style="color: #202124;">Professional Info</a>
                                                <div style="color: #5f6368; font-size: 12px; font-weight: 500;">{{ $member->position ?? 'N/A' }}</div>
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        @if($member->email)
                                        <div class="d-flex mb-8">
                                            <!--begin::Icon-->
                                            <div class="me-4">
                                                <div style="width: 40px; height: 40px; background: rgba(26, 115, 232, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #1a73e8; font-size: 18px;">
                                                    <i class="fas fa-envelope"></i>
                                                </div>
                                            </div>
                                            <!--end::Icon-->
                                            <!--begin::Info-->
                                            <div class="flex-grow-1">
                                                <a href="mailto:{{ $member->email }}" class="text-gray-900 text-hover-primary fw-bold fs-6" style="color: #202124;">{{ $member->email }}</a>
                                                <div style="color: #5f6368; font-size: 12px; font-weight: 500;">Email Address</div>
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::Item-->
                                        @endif
                                        <!--begin::Item-->
                                        @if($member->phone)
                                        <div class="d-flex mb-8">
                                            <!--begin::Icon-->
                                            <div class="me-4">
                                                <div style="width: 40px; height: 40px; background: rgba(52, 168, 83, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #34a853; font-size: 18px;">
                                                    <i class="fas fa-phone"></i>
                                                </div>
                                            </div>
                                            <!--end::Icon-->
                                            <!--begin::Info-->
                                            <div class="flex-grow-1">
                                                <a href="tel:{{ $member->phone }}" class="text-gray-900 text-hover-primary fw-bold fs-6" style="color: #202124;">{{ $member->phone }}</a>
                                                <div style="color: #5f6368; font-size: 12px; font-weight: 500;">Phone Number</div>
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::Item-->
                                        @endif
                                        <!--begin::Item-->
                                        @if($member->state)
                                        <div class="d-flex">
                                            <!--begin::Icon-->
                                            <div class="me-4">
                                                <div style="width: 40px; height: 40px; background: rgba(250, 123, 23, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fa7b17; font-size: 18px;">
                                                    <i class="fas fa-map"></i>
                                                </div>
                                            </div>
                                            <!--end::Icon-->
                                            <!--begin::Info-->
                                            <div class="flex-grow-1">
                                                <a href="#" class="text-gray-900 text-hover-primary fw-bold fs-6" style="color: #202124;">{{ $member->state }}</a>
                                                <div style="color: #5f6368; font-size: 12px; font-weight: 500;">State/Province</div>
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::Item-->
                                        @endif
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Sidebar Widget 2-->
                            </div>
                            <!--end::Sidebar-->

                            <!--begin::Content Column-->
                            <div class="col-xxl-9">
                                <!--begin::Card-->
                                <div class="card card-flush" style="background: #f8f9fa; border: none; box-shadow: 0 1px 3px rgba(32, 33, 36, 0.08);">
                                    <!--begin::Card header with nav tabs-->
                                    <div class="card-header border-0" style="background: #f8f9fa; border-bottom: 1px solid #e0e0e0;">
                                        <!--begin::Nav tabs-->
                                        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent flex-nowrap" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="overview-tab" data-bs-toggle="tab" href="#overview_pane" role="tab" style="color: #5f6368; border-bottom: 3px solid transparent;">
                                                    Overview
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="details-tab" data-bs-toggle="tab" href="#details_pane" role="tab" style="color: #5f6368; border-bottom: 3px solid transparent;">
                                                    Details
                                                </a>
                                            </li>
                                        </ul>
                                        <!--end::Nav tabs-->
                                    </div>
                                    <!--end::Card header-->

                                    <!--begin::Card body-->
                                    <div class="card-body pt-9 tab-content" style="background: white;">
                                        <!--begin::Tab pane: Overview-->
                                        <div class="tab-pane fade show active" id="overview_pane" role="tabpanel">
                                            <!--begin::Form group-->
                                            <div class="mb-8">
                                                <div class="fs-6 fw-bold mb-3" style="color: #202124;">Personal Information</div>
                                                <div class="row">
                                                    @if($member->firstname)
                                                    <div class="col-md-6 mb-5">
                                                        <div style="font-size: 12px; color: #5f6368; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">First Name</div>
                                                        <div style="color: #202124; font-size: 15px; font-weight: 600;">{{ $member->firstname }}</div>
                                                    </div>
                                                    @endif

                                                    @if($member->middlename)
                                                    <div class="col-md-6 mb-5">
                                                        <div style="font-size: 12px; color: #5f6368; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Middle Name</div>
                                                        <div style="color: #202124; font-size: 15px; font-weight: 600;">{{ $member->middlename }}</div>
                                                    </div>
                                                    @endif

                                                    @if($member->surname)
                                                    <div class="col-md-6 mb-5">
                                                        <div style="font-size: 12px; color: #5f6368; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Surname</div>
                                                        <div style="color: #202124; font-size: 15px; font-weight: 600;">{{ $member->surname }}</div>
                                                    </div>
                                                    @endif

                                                    @if($member->dob)
                                                    <div class="col-md-6 mb-5">
                                                        <div style="font-size: 12px; color: #5f6368; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Date of Birth</div>
                                                        <div style="color: #202124; font-size: 15px; font-weight: 600;">{{ $member->dob->format('F d, Y') }}</div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <!--end::Form group-->

                                            <!--begin::Form group-->
                                            <div class="mb-8">
                                                <div class="fs-6 fw-bold mb-3" style="color: #202124;">Professional Information</div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-5">
                                                        <div style="font-size: 12px; color: #5f6368; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Position</div>
                                                        <div style="color: #202124; font-size: 15px; font-weight: 600;">{{ $member->position ?? 'N/A' }}</div>
                                                    </div>

                                                    <div class="col-md-6 mb-5">
                                                        <div style="font-size: 12px; color: #5f6368; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Category</div>
                                                        <div>
                                                            <span class="badge" style="background: rgba(24, 90, 188, 0.1); color: #185abc;">
                                                                @if(strtoupper($member->category) === 'NWC')
                                                                    National Working Committee
                                                                @elseif(strtoupper($member->category) === 'NEC')
                                                                    National Executive Committee
                                                                @elseif(strtoupper($member->category) === 'DEP')
                                                                    Deputy
                                                                @elseif(strtoupper($member->category) === 'STAFF')
                                                                    Staff Member
                                                                @else
                                                                    {{ ucfirst(strtolower($member->category)) }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>

                                                    @if($member->seat)
                                                    <div class="col-md-6 mb-5">
                                                        <div style="font-size: 12px; color: #5f6368; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Assigned Seat</div>
                                                        <div style="color: #202124; font-size: 15px; font-weight: 600;">{{ $member->seat }}</div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <!--end::Form group-->

                                            <!--begin::Form group-->
                                            @if($member->email || $member->phone || ($member->state || $member->pscode))
                                            <div class="mb-8">
                                                <div class="fs-6 fw-bold mb-3" style="color: #202124;">Contact & Location</div>
                                                <div class="row">
                                                    @if($member->email)
                                                    <div class="col-md-6 mb-5">
                                                        <div style="font-size: 12px; color: #5f6368; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Email</div>
                                                        <a href="mailto:{{ $member->email }}" class="text-hover-primary" style="color: #1a73e8; font-size: 15px; font-weight: 600; text-decoration: none;">{{ $member->email }}</a>
                                                    </div>
                                                    @endif
                                                    @if($member->phone)
                                                    <div class="col-md-6 mb-5">
                                                        <div style="font-size: 12px; color: #5f6368; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Phone Number</div>
                                                        <a href="tel:{{ $member->phone }}" class="text-hover-primary" style="color: #1a73e8; font-size: 15px; font-weight: 600; text-decoration: none;">{{ $member->phone }}</a>
                                                    </div>
                                                    @endif

                                                    @if($member->state)
                                                    <div class="col-md-6 mb-5">
                                                        <div style="font-size: 12px; color: #5f6368; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">State/Province</div>
                                                        <div style="color: #202124; font-size: 15px; font-weight: 600;">{{ $member->state }}</div>
                                                    </div>
                                                    @endif

                                                    @if($member->pscode)
                                                    <div class="col-md-6 mb-5">
                                                        <div style="font-size: 12px; color: #5f6368; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Postal Code</div>
                                                        <div style="color: #202124; font-size: 15px; font-weight: 600;">{{ $member->pscode }}</div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                            <!--end::Form group-->

                                            <!--begin::Form group-->
                                            @if($member->email || $member->phone)
                                            <div class="d-flex gap-3">
                                                @if($member->email)
                                                <a href="mailto:{{ $member->email }}" class="btn" style="background: rgba(26, 115, 232, 0.1); color: #1a73e8; border: 1px solid rgba(26, 115, 232, 0.3); padding: 12px 20px; border-radius: 6px; font-weight: 600; text-decoration: none;">
                                                    <i class="fas fa-envelope me-2"></i> Email
                                                </a>
                                                @endif
                                                @if($member->phone)
                                                <a href="tel:{{ $member->phone }}" class="btn" style="background: #1a73e8; color: white; border: none; padding: 12px 20px; border-radius: 6px; font-weight: 600; text-decoration: none;">
                                                    <i class="fas fa-phone me-2"></i> Call
                                                </a>
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $member->phone) }}" target="_blank" class="btn" style="background: rgba(52, 168, 83, 0.1); color: #34a853; border: 1px solid rgba(52, 168, 83, 0.3); padding: 12px 20px; border-radius: 6px; font-weight: 600; text-decoration: none;">
                                                    <i class="fab fa-whatsapp me-2"></i> WhatsApp
                                                </a>
                                                @endif
                                            </div>
                                            @endif
                                            <!--end::Form group-->
                                        </div>
                                        <!--end::Tab pane: Overview-->

                                        <!--begin::Tab pane: Details-->
                                        <div class="tab-pane fade" id="details_pane" role="tabpanel">
                                            <!--begin::Form group-->
                                            <div class="mb-8">
                                                <div class="fs-6 fw-bold mb-3" style="color: #202124;">Full Profile Summary</div>
                                                <div class="row">
                                                    <div class="col-12 mb-5">
                                                        <div style="font-size: 12px; color: #5f6368; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Full Name</div>
                                                        <div style="color: #202124; font-size: 15px; font-weight: 600;">
                                                            @if($member->title)
                                                                {{ $member->title }}
                                                            @endif
                                                            {{ $member->firstname }} 
                                                            @if($member->middlename)
                                                                {{ $member->middlename }}
                                                            @endif
                                                            {{ $member->surname }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Form group-->

                                            <!--begin::Form group-->
                                            <div class="mb-8">
                                                <div class="fs-6 fw-bold mb-3" style="color: #202124;">Additional Information</div>
                                                <div class="table-responsive">
                                                    <table class="table table-flush table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <td style="font-size: 12px; color: #5f6368; font-weight: 600; text-transform: uppercase;">Category</td>
                                                                <td style="color: #202124; font-size: 15px; font-weight: 600;">{{ strtoupper($member->category) }}</td>
                                                            </tr>
                                                            @if($member->seat)
                                                            <tr>
                                                                <td style="font-size: 12px; color: #5f6368; font-weight: 600; text-transform: uppercase;">Seat</td>
                                                                <td style="color: #202124; font-size: 15px; font-weight: 600;">{{ $member->seat }}</td>
                                                            </tr>
                                                            @endif
                                                            @if($member->position)
                                                            <tr>
                                                                <td style="font-size: 12px; color: #5f6368; font-weight: 600; text-transform: uppercase;">Position</td>
                                                                <td style="color: #202124; font-size: 15px; font-weight: 600;">{{ $member->position }}</td>
                                                            </tr>
                                                            @endif
                                                            @if($member->dob)
                                                            <tr>
                                                                <td style="font-size: 12px; color: #5f6368; font-weight: 600; text-transform: uppercase;">DOB</td>
                                                                <td style="color: #202124; font-size: 15px; font-weight: 600;">{{ $member->dob->format('F d, Y') }}</td>
                                                            </tr>
                                                            @endif
                                                            @if($member->phone)
                                                            <tr>
                                                                <td style="font-size: 12px; color: #5f6368; font-weight: 600; text-transform: uppercase;">Email</td>
                                                                <td style="color: #202124; font-size: 15px; font-weight: 600;"><a href="mailto:{{ $member->email }}" style="color: #1a73e8; text-decoration: none;">{{ $member->email }}</a></td>
                                                            </tr>
                                                            @endif
                                                            @if($member->phone)
                                                            <tr>
                                                                <td style="font-size: 12px; color: #5f6368; font-weight: 600; text-transform: uppercase;">Phone</td>
                                                                <td style="color: #202124; font-size: 15px; font-weight: 600;"><a href="tel:{{ $member->phone }}" style="color: #1a73e8; text-decoration: none;">{{ $member->phone }}</a></td>
                                                            </tr>
                                                            @endif
                                                            @if($member->state)
                                                            <tr>
                                                                <td style="font-size: 12px; color: #5f6368; font-weight: 600; text-transform: uppercase;">State</td>
                                                                <td style="color: #202124; font-size: 15px; font-weight: 600;">{{ $member->state }}</td>
                                                            </tr>
                                                            @endif
                                                            @if($member->pscode)
                                                            <tr>
                                                                <td style="font-size: 12px; color: #5f6368; font-weight: 600; text-transform: uppercase;">Postal Code</td>
                                                                <td style="color: #202124; font-size: 15px; font-weight: 600;">{{ $member->pscode }}</td>
                                                            </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!--end::Form group-->
                                        </div>
                                        <!--end::Tab pane: Details-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                            </div>
                            <!--end::Content Column-->
                        </div>
                    </div>
                    <!--end::Content container-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Content wrapper-->
        </div>
        <!--end::Main-->
    </div>
</x-default-layout>
