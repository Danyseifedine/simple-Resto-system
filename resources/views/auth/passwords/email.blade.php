@extends('auth.layout.auth')

@section('title', 'email')


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
                        <div class="d-flex flex-stack py-2">
                            <!--begin::Back link-->
                            <div class="me-2"></div>
                            <!--end::Back link-->
                            <!--begin::Sign Up link-->
                            <div class="m-0">
                                <span class="text-gray-500 fw-bold fs-5 me-2">{{ __('auth.not_a_member') }}</span>
                                <a href="{{ route('register') }}"
                                    class="text-logo fw-bold fs-5">{{ __('auth.sign_up') }}</a>
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
                        <form form-id="send-email" feedback route="{{ route('password.email') }}"
                            identifier="single-form-post-handler" class="py-10" http-request success-toast>
                            @csrf
                            <!--begin::Heading-->
                            <div class="text-start mb-10">
                                <!--begin::Title-->
                                <h1 class="text-gray-900 mb-3 fs-3x">{{ __('auth.forget_password') }}</h1>
                                <!--end::Title-->
                                <!--begin::Text-->
                                <div class="text-gray-500 fw-semibold fs-6">
                                    {{ __('auth.enter_reset_email') }}
                                </div>
                                <!--end::Link-->
                            </div>
                            <!--begin::Heading-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-10 fv-plugins-icon-container">
                                <input type="text" feedback-id="email-feedback" placeholder="{{ __('common.email') }}"
                                    id="email" name="email" autocomplete="off"
                                    class="form-control form-control-solid form-control form-control-solid-solid" />
                                <div id="email-feedback" class="invalid-feedback fw-bold"></div>
                            </div>

                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="d-flex flex-stack">
                                <!--begin::Link-->
                                <div class="m-0 d-flex align-items-center gap-2">
                                    <button class="btn bg-logo d-flex align-items-center justify-content-center gap-2"
                                        loading-text="{{ __('common.sending') }}" submit-form-id="send-email"
                                        type="submit">
                                        {{ __('auth.send_pass') }}
                                    </button>
                                    <a href="{{ route('login') }}"
                                        class="btn text-logo fw-bold btn-hover">{{ __('common.cancel') }}</a>
                                </div>
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