@@extends('auth.layout.auth')

@section('title', 'Reset')


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
                            <div class="me-2">
                                <a href="{{ route('register') }}" class="btn btn-icon bg-light rounded-circle">
                                    <i class="ki-duotone ki-black-left fs-2 text-gray-800"></i>
                                </a>
                            </div>
                            <!--end::Back link-->
                            <!--begin::Sign Up link-->
                            <div class="m-0">
                                <span class="text-gray-500 fw-bold fs-5 me-2">{{ __('auth.already_have_account') }}</span>
                                <a href="{{ route('login') }}"
                                    class="text-logo fw-bold fs-5">{{ __('actions.sign_in') }}</a>
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
                        <form form-id="reset" feedback route="{{ route('password.update') }}"
                            identifier="single-form-post-handler"
                            class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework" redirect log="true"
                            http-request>
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">
                            <!--begin::Heading-->
                            <div class="text-start mb-10">
                                <!--begin::Title-->
                                <h1 class="text-gray-900 mb-3 fs-3x" data-kt-translate="new-password-title">
                                    {{ __('auth.setup_new_password') }}</h1>
                                <!--end::Title-->
                                <!--begin::Text-->
                                <div class="text-gray-500 fw-semibold fs-6" data-kt-translate="new-password-desc">
                                    {{ __('auth.has_reset_password') }}</div>
                                <!--end::Link-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="text" placeholder="{{ __('common.email') }}" id="email" name="email"
                                    autocomplete="off" feedback-id="email-feedback" class="form-control form-control-solid form-control form-control-solid-solid"
                                    value="{{ $email ?? old('email') }}" />
                                <div id="email-feedback" class="invalid-feedback fw-bold"></div>
                                <!--end::Email-->
                            </div>
                            <div class="mb-10 fv-row fv-plugins-icon-container" data-kt-password-meter="true">
                                <!--begin::Wrapper-->
                                <div class="mb-1">
                                    <!--begin::Input wrapper-->
                                    <div class="position-relative mb-3">
                                        <input class="form-control form-control-solid form-control form-control-solid-lg form-control form-control-solid-solid" type="password"
                                            placeholder="{{ __('common.password') }}" name="password" autocomplete="off"
                                            feedback-id="password-feedback" id="password">
                                        <span
                                            class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                            data-kt-password-meter-control="visibility">
                                            <i class="ki-duotone ki-eye-slash fs-2"></i>
                                            <i class="ki-duotone ki-eye fs-2 d-none"></i>
                                        </span>
                                    </div>
                                    <!--end::Input wrapper-->
                                    <!--begin::Meter-->
                                    <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                        </div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                        </div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                        </div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                    </div>
                                    <div id="password-feedback" class="invalid-feedback fw-bold"></div>
                                    <!--end::Meter-->
                                </div>
                                <!--end::Wrapper-->
                                <!--begin::Hint-->
                                <div class="text-muted" data-kt-translate="new-password-hint">
                                    {{ __('common.use_8_character') }}</div>
                                <!--end::Hint-->
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            <!--end::Input group=-->
                            <!--begin::Input group=-->
                            <div class="fv-row mb-10 fv-plugins-icon-container">
                                <input class="form-control form-control-solid form-control form-control-solid-lg form-control form-control-solid-solid" type="password"
                                    placeholder="{{ __('common.confirm_password') }}" name="password_confirmation"
                                    autocomplete="off" feedback-id="password_confirmation-feedback"
                                    id="password_confirmation">
                                <div id="password_confirmation-feedback" class="invalid-feedback fw-bold"></div>
                            </div>
                            <!--end::Input group=-->
                            <!--begin::Actions-->
                            <div class="d-flex flex-stack">
                                <!--begin::Link-->
                                <button class="btn bg-logo d-flex align-items-center justify-content-center gap-2"
                                    loading-text="{{ __('common.reseting') }}" submit-form-id="reset" type="submit">
                                    {{ __('auth.reset_password') }}
                                </button>
                                <!--end::Link-->
                                <!--begin::Social-->
                                <div class="d-flex align-items-center">
                                    <div class="text-gray-500 fw-semibold fs-6 me-3 me-md-6">{{ __('common.or') }}</div>
                                    <!--begin::Symbol-->
                                    <a href="#" class="symbol symbol-circle symbol-45px w-45px bg-light me-3">
                                        <img alt="Logo" src="{{ asset('core/vendor/img/icon/google-icon.svg') }}"
                                            class="p-4" />
                                    </a>
                                    <!--end::Symbol-->
                                    <!--begin::Symbol-->
                                    <a href="#" class="symbol symbol-circle symbol-45px w-45px bg-light me-3">
                                        <img alt="Logo" src="{{ asset('core/vendor/img/icon/facebook-3.svg') }}"
                                            class="p-4" />
                                    </a>
                                    <!--end::Symbol-->
                                </div>
                                <!--end::Social-->
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