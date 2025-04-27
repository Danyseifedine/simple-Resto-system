<div id="kt_app_header" class="app-header border-bottom border-gray-200 shadow-sm" data-kt-sticky="true"
    data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize"
    data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">
    <!--begin::Header container-->
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between"
        id="kt_app_header_container">

        <!--begin::Sidebar mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-40px h-40px rounded-circle"
                id="kt_app_sidebar_mobile_toggle">
                <i class="fa-solid fa-bars fs-2"></i>
            </div>
        </div>
        <!--end::Sidebar mobile toggle-->
        <!--begin::Mobile logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="{{ route('dashboard.index') }}" class="d-lg-none">
                <img alt="Logo" src="{{ asset('images/logo1.png') }}" class="h-100px" />
            </a>
        </div>

        <!--end::Mobile logo-->
        <!--begin::Header wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
            <!--begin::Menu wrapper-->
            <div class="d-flex align-items-center d-none d-lg-flex justify-content-start">
                <div class="app-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mini-breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.index') }}" class="text-primary">
                                    <i class="bi bi-house-door-fill fs-3"></i>
                                </a>
                            </li>
                            @if (isset($breadcrumbs))
                                @foreach ($breadcrumbs as $breadcrumb)
                                    @if ($loop->last)
                                        <li class="breadcrumb-item active fw-bold">{{ $breadcrumb['title'] }}</li>
                                    @else
                                        <li class="breadcrumb-item">
                                            <a href="{{ $breadcrumb['url'] }}"
                                                class="text-gray-600 hover-text-primary">{{ $breadcrumb['title'] }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true"
                data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
                data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end"
                data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
                data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
            </div>
            <!--end::Menu wrapper-->
            <!--begin::Navbar-->

            <div class="app-navbar flex-shrink-0">

                <!--begin::Theme mode-->
                @if (config('app.features.theme_mode'))
                    <div class="app-navbar-item ms-1 ms-md-3">
                        <!--begin::Direct theme toggle-->
                        <a href="#" id="kt_app_theme_toggle"
                            class="btn btn-icon btn-custom btn-active-light btn-active-color-primary w-35px h-35px rounded-circle">
                            <i class="bi bi-sun-fill theme-light-show fs-4 text-warning"></i>
                            <i class="bi bi-moon-fill theme-dark-show fs-4 text-primary"></i>
                        </a>
                    </div>
                @endif
                <!--end::Theme mode-->

                {{-- @role('admin')
                    <!--begin::Notifications-->
                    <div class="app-navbar-item ms-1 ms-md-3">
                        <div class="btn btn-icon btn-custom btn-active-light btn-active-color-primary w-35px h-35px rounded-circle position-relative"
                            data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent"
                            data-kt-menu-placement="bottom-end">
                            <i class="bi bi-bell-fill fs-4"></i>
                            @if ($unreadCount > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $unreadCount }}
                                    <span class="visually-hidden">unread notifications</span>
                                </span>
                            @endif
                        </div>
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-state-color fw-semibold py-4 fs-base w-350px shadow-sm"
                            data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <div class="menu-content d-flex align-items-center justify-content-between px-3">
                                    <div class="fw-bold text-gray-900">Notifications</div>
                                    <div>
                                        @if ($unreadCount > 0)
                                            <span class="badge badge-light-primary rounded-pill">{{ $unreadCount }}
                                                new</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu separator-->
                            <div class="separator my-2"></div>
                            <!--end::Menu separator-->

                            <!--begin::Menu items-->
                            <div class="menu-item px-3 notification-list" style="max-height: 300px; overflow-y: auto;">
                                <div class="menu-content p-2">
                                    @if ($notifications->count() > 0)
                                        @foreach ($notifications as $notification)
                                            <!--begin::Notification item-->
                                            <div class="d-flex flex-stack py-4 notification-item border-bottom">
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-35px me-4">
                                                        <span class="symbol-label bg-light-primary">
                                                            <i class="bi bi-water fs-2 text-primary"></i>
                                                        </span>
                                                    </div>
                                                    <div class="mb-0 me-2">
                                                        <a href="#"
                                                            class="fs-6 text-gray-800 text-hover-primary fw-bold">{{ $notification->title }}</a>
                                                        <div class="text-gray-500 fs-7">{{ $notification->description }}
                                                        </div>
                                                        <div class="d-flex align-items-center mt-1">
                                                            <span
                                                                class="text-muted fs-8 me-2">{{ $notification->created_at->diffForHumans() }}</span>
                                                            <div class="d-flex">
                                                                @if ($notification->isUnread())
                                                                    <a href="{{ route('dashboard.notifications.mark-as-read', $notification->id) }}"
                                                                        class="btn btn-sm btn-icon btn-light-primary me-1">
                                                                        <i class="bi bi-check fs-7"></i>
                                                                    </a>
                                                                @endif
                                                                <a href="{{ route('dashboard.notifications.delete', $notification->id) }}"
                                                                    class="btn btn-sm btn-icon btn-light-danger">
                                                                    <i class="bi bi-trash fs-7"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Notification item-->
                                        @endforeach
                                    @else
                                        <div class="text-center text-muted py-4">No notifications yet</div>
                                    @endif
                                </div>
                            </div>
                            <!--end::Menu items-->

                            <!--begin::Menu separator-->
                            <div class="separator my-2"></div>
                            <!--end::Menu separator-->

                            <!--begin::Action buttons-->
                            <div class="menu-item px-3">
                                <div class="d-flex justify-content-between px-3">
                                    <a href="{{ route('dashboard.notifications.mark-all-read') }}"
                                        class="btn btn-sm btn-light-primary">
                                        <i class="bi bi-check-all me-1"></i> Mark All Read
                                    </a>
                                    <a href="{{ route('dashboard.notifications.clear-all') }}"
                                        class="btn btn-sm btn-light-danger">
                                        <i class="bi bi-trash me-1"></i> Clear All
                                    </a>
                                </div>
                            </div>
                            <!--end::Action buttons-->
                        </div>
                        <!--end::Menu-->
                    </div>
                    <!--end::Notifications-->
                @endrole --}}

                <!--begin::Language selector-->
                @if (config('app.features.multi_lang'))
                    <div class="app-navbar-item ms-1 ms-md-3">
                        <div class="btn btn-icon btn-custom btn-active-light btn-active-color-primary w-35px h-35px rounded-circle"
                            data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent"
                            data-kt-menu-placement="bottom-end">
                            @if (LaravelLocalization::getCurrentLocale() == 'en')
                                <img class="w-20px h-20px rounded-1"
                                    src="{{ asset('core/vendor/img/flags/united-states.svg') }}" alt="" />
                            @else
                                <img class="w-20px h-20px rounded-1"
                                    src="{{ asset('core/vendor/img/flags/saudi-arabia.svg') }}" alt="" />
                            @endif
                        </div>
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-state-color fw-semibold py-4 fs-base w-175px shadow-sm"
                            data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="{{ LaravelLocalization::getLocalizedURL('en') }}"
                                    class="menu-link d-flex px-5 {{ LaravelLocalization::getCurrentLocale() == 'en' ? 'active' : '' }}">
                                    <span class="symbol symbol-20px me-4">
                                        <img class="rounded-1"
                                            src="{{ asset('core/vendor/img/flags/united-states.svg') }}"
                                            alt="" />
                                    </span>{{ __('common.english') }}</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="{{ LaravelLocalization::getLocalizedURL('ar') }}"
                                    class="menu-link d-flex px-5 {{ LaravelLocalization::getCurrentLocale() == 'ar' ? 'active' : '' }}">
                                    <span class="symbol symbol-20px me-4">
                                        <img class="rounded-1"
                                            src="{{ asset('core/vendor/img/flags/saudi-arabia.svg') }}"
                                            alt="" />
                                    </span>{{ __('common.arabic') }}</a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                    </div>
                @endif
                <!--end::Language selector-->

                <!--begin::User menu-->
                <div class="app-navbar-item ms-1 ms-md-3" id="kt_header_user_menu_toggle">
                    <!--begin::Menu wrapper-->
                    <div class="cursor-pointer symbol symbol-35px"
                        data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
                        data-kt-menu-placement="bottom-end">
                        <img src="{{ asset('core/vendor/img/default/default.webp') }}"
                            class="rounded-circle shadow-sm border border-gray-200" alt="user" />
                    </div>
                    <!--begin::User account menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-300px shadow-sm"
                        data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-60px me-5">
                                    <img alt="Logo" src="{{ asset('core/vendor/img/default/default.webp') }}"
                                        class="border border-gray-200 rounded-circle shadow-sm" />
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Username-->
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">{{ $user->name }}
                                        <span
                                            class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Admin</span>
                                    </div>
                                    <a href="#"
                                        class="fw-semibold text-muted text-hover-primary fs-7">{{ $user->email }}</a>
                                </div>
                                <!--end::Username-->
                            </div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="#" class="menu-link px-5" data-bs-toggle="modal" data-bs-target="#profileModal">
                                <i class="bi bi-person-fill me-2 fs-6"></i> My Profile
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="#" class="menu-link px-5" data-bs-toggle="modal" data-bs-target="#settingsModal">
                                <i class="bi bi-gear-fill me-2 fs-6"></i> Settings
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="{{ route('logout') }}" class="menu-link px-5">
                                <i class="bi bi-box-arrow-right me-2 fs-6 text-danger"></i>
                                {{ __('actions.log_out') }}
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::User account menu-->
                    <!--end::Menu wrapper-->
                </div>
                <!--end::User menu-->
                <!--begin::Aside toggle-->
                <!--end::Header menu toggle-->
            </div>
            <!--end::Navbar-->
        </div>
        <!--end::Header wrapper-->
    </div>
    <!--end::Header container-->
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const themeToggleBtn = document.getElementById('kt_app_theme_toggle');

        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Check if KTThemeMode is available
                if (typeof KTThemeMode !== 'undefined') {
                    // Get current mode
                    const currentMode = KTThemeMode.getMode();

                    // Toggle mode
                    const newMode = currentMode === 'light' ? 'dark' : 'light';

                    // Set the new mode
                    KTThemeMode.setMode(newMode);
                }
            });
        }
    });
</script>

<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">My Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-5">
                    <div class="symbol symbol-100px symbol-circle mb-3">
                        <img src="{{ asset('core/vendor/img/default/default.webp') }}" alt="user" />
                    </div>
                    <div class="fs-2 fw-bold">{{ $user->name }}</div>
                    <div class="fs-6 text-gray-600">{{ $user->email }}</div>
                    <div class="d-flex justify-content-center mt-2">
                        <span class="badge badge-light-success fs-7 fw-bold">Admin</span>
                    </div>
                </div>

                <div class="border rounded p-5 mb-5">
                    <div class="fs-5 fw-bold mb-3">Account Information</div>
                    <div class="d-flex flex-column">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Name:</span>
                            <span class="fw-bold">{{ $user->name }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Email:</span>
                            <span class="fw-bold">{{ $user->email }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Role:</span>
                            <span class="fw-bold">{{ $user->roles->first()->name ?? 'User' }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-gray-600">Joined:</span>
                            <span class="fw-bold">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#settingsModal">Edit Profile</button>
            </div>
        </div>
    </div>
</div>

<!-- Settings Modal -->
<div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="settingsModalLabel">Account Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#profile_tab">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#password_tab">Password</a>
                    </li>
                </ul>

                <div class="tab-content" id="settingsTabContent">
                    <!-- Profile Tab -->
                    <div class="tab-pane fade show active" id="profile_tab" role="tabpanel">
                        <form id="profile_form" action="{{ route('dashboard.profile.update') }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label for="name" class="form-label required">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label required">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>

                    <!-- Password Tab -->
                    <div class="tab-pane fade" id="password_tab" role="tabpanel">
                        <form id="password_form" action="{{ route('dashboard.profile.password') }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label for="current_password" class="form-label required">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label required">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label required">Confirm New Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
