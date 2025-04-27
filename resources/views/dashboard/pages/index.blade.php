@extends('dashboard.layout.index')

@section('content')
    <div class="card">
        <div class="card-body p-lg-10">
            <div class="mb-10">
                <div class="d-flex align-items-center mb-4">
                    <div class="symbol symbol-50px me-5">
                        <span class="symbol-label bg-light-primary">
                            <i class="bi bi-shop fs-2x text-primary"></i>
                        </span>
                    </div>
                    <div>
                        <h1 class="fw-bold text-dark mb-0">Casa de Familia Restaurant</h1>
                        <div class="text-muted fs-6">Management Dashboard</div>
                    </div>
                </div>

                <div class="separator my-10"></div>

                <div class="row g-10">
                    <div class="col-md-6">
                        <h2 class="fw-bold mb-4">Welcome to the Restaurant Management System</h2>
                        <p class="fs-5 text-gray-600">
                            This comprehensive system helps you manage all aspects of your restaurant efficiently.
                            Update your menu, manage reservations, schedule events, and engage with your customers.
                        </p>

                        <h3 class="fw-bold mt-8 mb-4">Key Features</h3>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-center">
                                <span class="bullet bullet-dot bg-primary me-3"></span>
                                <span class="fw-semibold fs-5">Menu management with categories</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="bullet bullet-dot bg-primary me-3"></span>
                                <span class="fw-semibold fs-5">Event scheduling and promotion</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="bullet bullet-dot bg-primary me-3"></span>
                                <span class="fw-semibold fs-5">Reservation tracking and management</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="bullet bullet-dot bg-primary me-3"></span>
                                <span class="fw-semibold fs-5">Customer feedback and testimonials</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="bullet bullet-dot bg-primary me-3"></span>
                                <span class="fw-semibold fs-5">Staff scheduling and management</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-header">
                                <h3 class="card-title">Quick Navigation</h3>
                            </div>
                            <div class="card-body">
                                <div class="row g-5">
                                    <div class="col-6">
                                        <a href="{{ route('dashboard.menus.index') }}" class="text-decoration-none">
                                            <div class="card bg-light-primary hoverable card-xl-stretch mb-5 mb-xl-8">
                                                <div class="card-body">
                                                    <i class="bi bi-menu-button-wide text-primary fs-3x mb-2"></i>
                                                    <div class="text-primary fw-bold fs-5 mb-2 mt-5">Menu</div>
                                                    <div class="fw-semibold text-gray-600">Manage your restaurant menu</div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-6">
                                        <a href="{{ route('dashboard.categories.index') }}" class="text-decoration-none">
                                            <div class="card bg-light-success hoverable card-xl-stretch mb-5 mb-xl-8">
                                                <div class="card-body">
                                                    <i class="bi bi-collection text-success fs-3x mb-2"></i>
                                                    <div class="text-success fw-bold fs-5 mb-2 mt-5">Categories</div>
                                                    <div class="fw-semibold text-gray-600">Manage menu categories</div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-6">
                                        <a href="{{ route('dashboard.events.index') }}" class="text-decoration-none">
                                            <div class="card bg-light-info hoverable card-xl-stretch mb-5 mb-xl-8">
                                                <div class="card-body">
                                                    <i class="bi bi-calendar-event text-info fs-3x mb-2"></i>
                                                    <div class="text-info fw-bold fs-5 mb-2 mt-5">Events</div>
                                                    <div class="fw-semibold text-gray-600">Schedule and manage events</div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-6">
                                        <a href="{{ route('dashboard.users.index') }}" class="text-decoration-none">
                                            <div class="card bg-light-warning hoverable card-xl-stretch mb-5 mb-xl-8">
                                                <div class="card-body">
                                                    <i class="bi bi-people text-warning fs-3x mb-2"></i>
                                                    <div class="text-warning fw-bold fs-5 mb-2 mt-5">Users</div>
                                                    <div class="fw-semibold text-gray-600">Manage system users</div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="separator my-10"></div>

                <div class="d-flex flex-stack">
                    <div>
                        <h3 class="fw-bold">Need Help?</h3>
                        <p class="text-gray-600 fs-6">Check out our documentation or contact support</p>
                    </div>
                    <a href="{{ route('contact') }}" class="btn btn-light-primary">Contact Support</a>
                </div>
            </div>
        </div>
    </div>
@endsection
