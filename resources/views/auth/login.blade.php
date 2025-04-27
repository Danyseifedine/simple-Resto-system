@extends('auth.layout.auth')

@section('title', 'Login')


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
                        <div class="flex items-center mb-10">
                            <a href="{{ route('welcome') }}" class="flex items-center">
                                <img src="{{ asset('images/Casalogo.png') }}" alt="HydroFuel Master Logo"
                                    style="width: 100%; height: 100%;">
                            </a>
                        </div>
                        <!--begin::Form-->
                        <form form-id="login" route="{{ route('login') }}" identifier="single-form-post-handler"
                            http-request feedback redirect>

                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin::Heading-->
                                <div class="text-start mb-10">
                                    <!--begin::Title-->
                                    <h1 class="text-gray-900 mb-3 fs-3x">Welcome Back</h1>
                                    <!--end::Title-->
                                    <!--begin::Text-->
                                    <div class="text-gray-500 fw-semibold fs-6">Please enter your details to login
                                    </div>
                                    <!--end::Link-->
                                </div>
                                <!--begin::Heading-->
                                <!--begin::Input group=-->
                                <div class="fv-row mb-8">
                                    <!--begin::Email-->
                                    <input type="text" feedback-id="email-feedback"
                                        placeholder="{{ __('common.email') }}" id="email" name="email"
                                        autocomplete="off"
                                        class="form-control form-control-solid form-control form-control-solid-solid" />
                                    <div id="email-feedback" class="invalid-feedback fw-bold"></div>
                                    <!--end::Email-->
                                </div>
                                <!--end::Input group=-->
                                <div class="fv-row mb-7">
                                    <!--begin::Password-->
                                    <input type="password" feedback-id="password-feedback"
                                        placeholder="{{ __('common.password') }}" id="password" name="password"
                                        autocomplete="off"
                                        class="form-control form-control-solid form-control form-control-solid-solid" />
                                    <div id="password-feedback" class="invalid-feedback fw-bold"></div>
                                    <!--end::Password-->
                                </div>
                                <!--end::Input group=-->
                                <!--begin::Actions-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Submit-->
                                    <button submit-form-id="login" loading-text="{{ __('common.loggingin') }}"
                                        class="btn bg-logo d-flex align-items-center justify-content-center gap-2"
                                        type="submit">
                                        {{ __('validation.attributes.login') }}
                                    </button>
                                    <!--end::Submit-->
                                </div>
                                <!--end::Actions-->
                            </div>

                            <!--begin::Body-->
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
