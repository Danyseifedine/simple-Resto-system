@extends('auth.layout.auth')

@section('title', 'Verification')


@section('content')
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="auth d-flex flex-column flex-center flex-column-fluid p-10">
            <!--begin::Authentication - Sign-in -->
            <div class="d-flex flex-column flex-lg-row flex-column-fluid">
                <!--begin::Aside-->
                <div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column-fluid flex-column w-100 mw-450px">
                        <!--begin::Header-->
                        <div class="d-flex flex-stack py-2 justify-content-end">
                            <!--begin::Sign Up link-->
                            <div class="m-0 d-flex">
                                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                    @csrf
                                    <a href=""
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        class="text-logo fw-bold fs-5">{{ __('actions.log_out') }}</a>
                                </form>
                            </div>
                            <!--end::Sign Up link=-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="text-center fs-2 fw-bold py-20">
                            <img src="{{ asset('core/vendor/img/logo/logo-icon.png') }}" width="70" alt=""
                                style="animation: spin 2s linear infinite;">
                        </div>
                        <!--begin::Form-->
                        <form form-id="verify" feedback route="{{ route('verification.resend') }}"
                            identifier="single-form-post-handler" class="py-20" http-request success-toast>
                            @csrf

                            <!--begin::Heading-->
                            <div class="text-start mb-10">
                                <!--begin::Title-->
                                <h1 class="text-gray-900 mb-3 fs-3x" data-kt-translate="new-password-title">
                                    {{ __('auth.email_verification') }}</h1>
                                <!--end::Title-->
                                <!--begin::Text-->
                                <div class="text-gray-500 fw-semibold fs-6" data-kt-translate="new-password-desc">
                                    {{ __('auth.access_features') }}
                                </div>
                                <!--end::Link-->
                            </div>
                            <!--end::Heading-->

                            <!--begin::Actions-->
                            <div class="d-flex flex-stack">
                                <!--begin::Link-->
                                <button class="btn bg-logo d-flex align-items-center justify-content-center gap-2"
                                    loading-text="{{ __('common.sending') }}" submit-form-id="verify" type="submit">
                                    {{ __('auth.send_verification_email') }}
                                </button>
                                <!--end::Link-->
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    {{-- multi lang --}}
                    @include('auth.components.footer')
                    <!--end::Footer-->
                </div>
                <!--end::Wrapper-->
            </div>

            <!--begin::Body-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
@endsection