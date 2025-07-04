<!DOCTYPE html>
<html data-navigation-type="default" data-navbar-horizontal-shape="default" data-bs-theme="light"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>@yield('title') | {{ env('APP_NAME') }}</title>
    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('core/vendor/img/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('core/vendor/img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('core/vendor/img/favicons/favicon-16x16.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('core/vendor/img/favicons/favicon.ico') }}">
    <meta name="msapplication-TileColor" content="#008382">
    <meta name="msapplication-TileImage" content="{{ asset('core/vendor/img/favicons/mstile-150x150.png') }}">
    <!-- ===============================================-->
    <!--    Package-->
    <!-- ===============================================-->
    <link rel="stylesheet" href="{{ asset('core/packages/iziToast/iziToast.min.css') }}">
    <!-- ===============================================-->
    <!--    Meta-->
    <!-- ===============================================-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="google" content="notranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#FFFFFF" />
    <meta name="author" content="Dany Seifeddine">
    <meta name="robots" content="index, nofollow">
    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    @if (LaravelLocalization::getCurrentLocaleDirection() === 'rtl')
        <link href="{{ url('core/vendor/css/datatables.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('core/vendor/css/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('core/vendor/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    @else
        <link href="{{ url('core/vendor/css/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('core/vendor/css/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('core/vendor/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    @endif
    @stack('styles')
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-layout="light-sidebar" data-kt-app-header-fixed="true"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
    data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!--begin::Header-->
            @include('dashboard.common.navbar')
            <!--end::Header-->
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!--begin::Sidebar-->
                @include('dashboard.common.sidebar')
                <!--end::Sidebar-->
                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        <!--begin::Content-->
                        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                            <!--begin::Toolbar container-->
                            <div id="kt_app_toolbar_container" class="app-container d-flex flex-stack">
                                @yield('toolbar')
                            </div>
                        </div>
                        <!--begin::Content-->
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <!--begin::Content container-->
                            <div id="kt_app_content_container" class="app-container">
                                @yield('content')
                            </div>
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Content wrapper-->
                    <!--begin::Footer-->
                    <div id="kt_app_footer" class="app-footer">
                        <!--begin::Footer container-->
                        @include('dashboard.common.footer')
                        <!--end::Footer container-->
                    </div>
                    <!--end::Footer-->
                </div>
                <!--end:::Main-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>

    <script src="{{ asset('core/packages/iziToast/iziToast.min.js') }}"></script>
    <script src="{{ url('core/vendor/js/plugins.bundle.js') }}"></script>
    <script src="{{ url('core/vendor/js/scripts.bundle.js') }}"></script>
    <script src="{{ url('core/vendor/js/datatables.bundle.js') }}"></script>
    <script src="{{ asset('core/global/Launcher.js') }}" type="module"></script>
    <script src="{{ asset('js/dashboard/profile.js') }}"></script>
    @stack('scripts')
</body>
<!--end::Body-->

</html>
