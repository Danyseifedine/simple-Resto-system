<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <h1>
            Casa de Familia
        </h1>
        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <i class="bi bi-arrow-right-short fs-3 rotate-180"></i>
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
            <!--begin::Scroll wrapper-->
            <div id="kt_app_sidebar_menu_scroll" class="my-2" data-kt-scroll="true" data-kt-scroll-activate="true"
                data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="50px"
                data-kt-scroll-save-state="true">
                <!--begin::Menu-->
                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu"
                    data-kt-menu="true" data-kt-menu-expand="false">
                    @foreach (config('sidebar.menu_items') as $menuItem)
                        <x-dashboard.lebify-sidebar :item="$menuItem" />
                    @endforeach
                </div>

                <!--end::Menu-->
            </div>
            <!--end::Scroll wrapper-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->

    <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
        <!-- Footer items from config -->
        @foreach (config('sidebar.footer_items', []) as $footerItem)
            <a href="{{ isset($footerItem['is_route']) && $footerItem['is_route'] ? route($footerItem['link']) : $footerItem['link'] }}"
                class="btn btn-flex flex-center btn-custom btn-primary overflow-hidden text-nowrap px-0 h-40px w-100 mb-2"
                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click"
                data-bs-original-title="{{ $footerItem['title'] }}" data-kt-initialized="1">
                <span class="btn-label">{{ __($footerItem['title']) }}</span>
                @if (isset($footerItem['icon']))
                    <i class="{{ $footerItem['icon'] }} btn-icon mx-3 fs-2 m-0">
                        @if (isset($footerItem['icon_paths']))
                            @foreach ($footerItem['icon_paths'] as $path)
                                <span class="{{ $path }}"></span>
                            @endforeach
                        @endif
                    </i>
                @endif
            </a>

            @if (!$loop->last)
                <div class="separator separator-dashed my-3"></div>
            @endif
        @endforeach
    </div>
</div>
