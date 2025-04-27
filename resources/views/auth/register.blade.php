@extends('auth.layout.auth')

@section('title', 'Register')


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
                                <span class="text-gray-500 fw-bold fs-5 me-2">{{ __('auth.already_have_account') }}</span>
                                <a href="{{ route('login') }}"
                                    class="text-logo fw-bold fs-5">{{ __('actions.sign_in') }}</a>
                            </div>
                            <!--end::Sign Up link=-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="flex items-center mb-10">
                            <a href="{{ route('welcome') }}" class="flex items-center">
                                <img src="{{ asset('images/Casalogo.png') }}" alt="HydroFuel Master Logo"
                                    style="width: 100%; height: 100%;">
                            </a>
                        </div>
                        <!--begin::Form-->
                        <form form-id="register" route="{{ route('register') }}" identifier="single-form-post-handler"
                            http-request feedback redirect>
                            @csrf
                            <!--begin::Heading-->
                            <div class="text-start mb-10">
                                <!--begin::Title-->
                                <h1 class="text-gray-900 mb-3 fs-3x">{{ __('auth.join_now') }}</h1>
                                <!--end::Title-->
                                <!--begin::Text-->
                                <div class="text-gray-500 fw-semibold fs-6">{{ __('auth.explore_a_sanctuary') }}</div>
                                <!--end::Link-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Input group-->
                            <div class="row fv-row mb-7">
                                <!--begin::Col-->
                                <div class="col-xl-12">
                                    <input
                                        class="form-control form-control-solid form-control form-control-solid-lg form-control form-control-solid-solid"
                                        type="text" placeholder="{{ __('common.full_name') }}"
                                        feedback-id="name-feedback" name="name" id="name" autocomplete="off" />
                                    <div id="name-feedback" class="invalid-feedback fw-bold"></div>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <input
                                    class="form-control form-control-solid form-control form-control-solid-lg form-control form-control-solid-solid"
                                    type="text" placeholder="{{ __('common.email') }}" feedback-id="email-feedback"
                                    name="email" id="email" autocomplete="off" />
                                <div id="email-feedback" class="invalid-feedback fw-bold"></div>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-10" data-kt-password-meter="true">
                                <!--begin::Wrapper-->
                                <div class="mb-1">
                                    <!--begin::Input wrapper-->
                                    <div class="position-relative mb-3">
                                        <input
                                            class="form-control form-control-solid form-control form-control-solid-lg form-control form-control-solid-solid"
                                            type="password" placeholder="{{ __('common.password') }}"
                                            feedback-id="password-feedback" name="password" autocomplete="off"
                                            id="password" />
                                        <div id="password-feedback" class="invalid-feedback fw-bold"></div>
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
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                    </div>
                                    <!--end::Meter-->
                                </div>
                                <!--end::Wrapper-->
                                <!--begin::Hint-->
                                <div class="text-muted" data-kt-translate="sign-up-hint">{{ __('auth.use_8_character') }}
                                </div>
                                <!--end::Hint-->
                            </div>
                            <!--end::Input group=-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <input
                                    class="form-control form-control-solid form-control form-control-solid-lg form-control form-control-solid-solid"
                                    type="password" placeholder="{{ __('common.confirm_password') }}"
                                    feedback-id="password_confirmation-feedback" id="password_confirmation"
                                    name="password_confirmation" autocomplete="off" />
                                <div id="password_confirmation-feedback" class="invalid-feedback fw-bold"></div>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="d-flex flex-stack">
                                <!--begin::Submit-->
                                <button class="btn bg-logo d-flex align-items-center justify-content-center gap-2"
                                    loading-text="{{ __('common.registering') }}" submit-form-id="register" type="submit">
                                    {{ __('auth.register') }}
                                </button>
                                <!--end::Submit-->
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
