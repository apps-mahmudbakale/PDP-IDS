<!--begin::Menu wrapper-->
<div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
	<!--begin::Menu-->
	<div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">
		
		<!--begin:Menu item - Dashboard-->
		<div class="menu-item me-0 me-lg-2">
			<!--begin:Menu link-->
			<a class="menu-link" href="{{ route('dashboard') }}">
				<span class="menu-title">Dashboard</span>
			</a>
			<!--end:Menu link-->
		</div>
		<!--end:Menu item-->

		<!--begin:Menu item - Members-->
		<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-0 me-lg-2">
			<!--begin:Menu link-->
			<span class="menu-link">
				<span class="menu-title">Members</span>
				<span class="menu-arrow d-lg-none"></span>
			</span>
			<!--end:Menu link-->
			<!--begin:Menu sub-->
			<div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown p-0 w-100 w-lg-250px">
				<!--begin:Menu item-->
				<div class="menu-item">
					<!--begin:Menu link-->
					<a class="menu-link" href="{{ route('members.nwc.index') }}">
						<span class="menu-bullet">
							<span class="bullet bullet-dot"></span>
						</span>
						<span class="menu-title">NWC Members</span>
					</a>
					<!--end:Menu link-->
				</div>
				<!--end:Menu item-->

				<!--begin:Menu item-->
				<div class="menu-item">
					<!--begin:Menu link-->
					<a class="menu-link" href="{{ route('members.nec.index') }}">
						<span class="menu-bullet">
							<span class="bullet bullet-dot"></span>
						</span>
						<span class="menu-title">NEC Members</span>
					</a>
					<!--end:Menu link-->
				</div>
				<!--end:Menu item-->

				<!--begin:Menu item-->
				<div class="menu-item">
					<!--begin:Menu link-->
					<a class="menu-link" href="{{ route('members.deps.index') }}">
						<span class="menu-bullet">
							<span class="bullet bullet-dot"></span>
						</span>
						<span class="menu-title">DEP Members</span>
					</a>
					<!--end:Menu link-->
				</div>
				<!--end:Menu item-->

				<!--begin:Menu separator-->
				<div class="separator my-2"></div>
				<!--end:Menu separator-->

				<!--begin:Menu item-->
				<div class="menu-item">
					<!--begin:Menu link-->
					<a class="menu-link" href="{{ route('members.nwc.create') }}">
						<span class="menu-bullet">
							<span class="bullet bullet-dot"></span>
						</span>
						<span class="menu-title">
							<i class="fas fa-plus fs-7"></i> Add Member
						</span>
					</a>
					<!--end:Menu link-->
				</div>
				<!--end:Menu item-->
			</div>
			<!--end:Menu sub-->
		</div>
		<!--end:Menu item-->

		<!--begin:Menu item - Meetings-->
		<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-0 me-lg-2">
			<!--begin:Menu link-->
			<span class="menu-link">
				<span class="menu-title">Meetings</span>
				<span class="menu-arrow d-lg-none"></span>
			</span>
			<!--end:Menu link-->
			<!--begin:Menu sub-->
			<div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown p-0 w-100 w-lg-250px">
				<!--begin:Menu item-->
				<div class="menu-item">
					<!--begin:Menu link-->
					<a class="menu-link" href="{{ route('meetings.index') }}">
						<span class="menu-bullet">
							<span class="bullet bullet-dot"></span>
						</span>
						<span class="menu-title">All Meetings</span>
					</a>
					<!--end:Menu link-->
				</div>
				<!--end:Menu item-->

				<!--begin:Menu separator-->
				<div class="separator my-2"></div>
				<!--end:Menu separator-->

				<!--begin:Menu item-->
				<div class="menu-item">
					<!--begin:Menu link-->
					<a class="menu-link" href="{{ route('meetings.create') }}">
						<span class="menu-bullet">
							<span class="bullet bullet-dot"></span>
						</span>
						<span class="menu-title">
							<i class="fas fa-plus fs-7"></i> New Meeting
						</span>
					</a>
					<!--end:Menu link-->
				</div>
				<!--end:Menu item-->
			</div>
			<!--end:Menu sub-->
		</div>
		<!--end:Menu item-->

		<!--begin:Menu item - Management-->
		<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-0 me-lg-2">
			<!--begin:Menu link-->
			<span class="menu-link">
				<span class="menu-title">Management</span>
				<span class="menu-arrow d-lg-none"></span>
			</span>
			<!--end:Menu link-->
			<!--begin:Menu sub-->
			<div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown p-0 w-100 w-lg-250px">
				<!--begin:Menu item-->
				<div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
					<!--begin:Menu link-->
					<span class="menu-link">
						<span class="menu-bullet">
							<span class="bullet bullet-dot"></span>
						</span>
						<span class="menu-title">Users</span>
						<span class="menu-arrow"></span>
					</span>
					<!--end:Menu link-->
					<!--begin:Menu sub-->
					<div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px">
						<!--begin:Menu item-->
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link" href="{{ route('user-management.users.index') }}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Users List</span>
							</a>
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->
					</div>
					<!--end:Menu sub-->
				</div>
				<!--end:Menu item-->

				<!--begin:Menu item-->
				<div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
					<!--begin:Menu link-->
					<span class="menu-link">
						<span class="menu-bullet">
							<span class="bullet bullet-dot"></span>
						</span>
						<span class="menu-title">Roles</span>
						<span class="menu-arrow"></span>
					</span>
					<!--end:Menu link-->
					<!--begin:Menu sub-->
					<div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px">
						<!--begin:Menu item-->
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link" href="{{ route('user-management.roles.index') }}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Roles List</span>
							</a>
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->
					</div>
					<!--end:Menu sub-->
				</div>
				<!--end:Menu item-->

				<!--begin:Menu item-->
				<div class="menu-item">
					<!--begin:Menu link-->
					<a class="menu-link" href="{{ route('user-management.permissions.index') }}">
						<span class="menu-bullet">
							<span class="bullet bullet-dot"></span>
						</span>
						<span class="menu-title">Permissions</span>
					</a>
					<!--end:Menu link-->
				</div>
				<!--end:Menu item-->
			</div>
			<!--end:Menu sub-->
		</div>
		<!--end:Menu item-->

	</div>
	<!--end::Menu-->
</div>
<!--end::Menu wrapper-->
