@php
    $shouldDisplay = true;
    $hasRequiredRole = true;
    $hasRequiredPermission = true;

    // Check roles if they exist in the item
    if (isset($item['roles']) && !empty($item['roles'])) {
        $hasRequiredRole = false;
        foreach ($item['roles'] as $role) {
            if (auth()->check() && auth()->user()->hasRole($role)) {
                $hasRequiredRole = true;
                break;
            }
        }
    }

    // Check permissions if they exist in the item
    if (isset($item['permissions']) && !empty($item['permissions'])) {
        $hasRequiredPermission = false;
        foreach ($item['permissions'] as $permission) {
            // Try different permission check methods since we're not sure which one your app uses
        if (
            auth()->check() &&
            (auth()->user()->can($permission) ||
                auth()->user()->hasPermission($permission) ||
                (method_exists(auth()->user(), 'hasPermission') && auth()->user()->hasPermission($permission)))
            ) {
                $hasRequiredPermission = true;
                break;
            }
        }
    }

    // User should see the menu item if they have the required role OR the required permission
    // If only roles are specified, check only roles
    // If only permissions are specified, check only permissions
    // If both are specified, either one should grant access
    $shouldDisplay = $hasRequiredRole && $hasRequiredPermission;
@endphp

@if ($shouldDisplay)
    @if (isset($item['is_heading']))
        <div class="menu-item pt-5">
            <div class="menu-content">
                <span class="menu-heading fw-bold text-uppercase fs-7">{{ __($item['title']) }}</span>
            </div>
        </div>
    @else
        <div data-kt-menu-trigger="{{ isset($item['submenu']) ? 'click' : '' }}"
            class="menu-item mb-2 mx-2 rounded-3 {{ isset($item['submenu']) ? 'menu-accordion' : '' }}
            {{ isset($item['route_in']) && request()->routeIs($item['route_in']) ? 'here show' : '' }}
            {{ isset($item['is_route']) && $item['is_route'] && request()->routeIs($item['link']) ? 'active' : '' }}
            {{ isset($item['submenu']) ? 'parent-accordion' : '' }}">

            @if (isset($item['submenu']))
                <span class="menu-link dropdown-parent">
                    @if (isset($item['icon']))
                        <span class="menu-icon">
                            <i class="{{ $item['icon'] }}"></i>
                        </span>
                    @endif
                    <span class="menu-title">{{ __($item['title']) }}</span>
                    <span class="menu-arrow"></span>
                </span>
            @else
                <a class="menu-link"
                    href="{{ isset($item['is_route']) && $item['is_route'] ? route($item['link']) : $item['link'] }}">
                    @if (isset($item['icon']))
                        <span class="menu-icon">
                            <i class="{{ $item['icon'] }}"></i>
                        </span>
                    @endif
                    <span class="menu-title">{{ __($item['title']) }}</span>
                </a>
            @endif

            @if (isset($item['submenu']))
                <div class="menu-sub menu-sub-accordion">
                    @foreach ($item['submenu'] as $submenu)
                        @php
                            // Create a new item with the submenu data to reuse the component
                            $submenuItem = $submenu;
                        @endphp
                        <x-dashboard.lebify-sidebar :item="$submenuItem" />
                    @endforeach
                </div>
            @endif
        </div>
    @endif
@endif

<style>
    [data-bs-theme="dark"] .menu-item.active .menu-title {
        color: #ffffff;
        font-weight: 500;
    }

    [data-bs-theme="dark"] .menu-item.active .menu-icon i {
        color: #ffffff;
    }

    [data-bs-theme="dark"] .menu-item.parent-accordion .menu-title {
        color: #e6e6e6;
        font-weight: 500;
    }


    [data-bs-theme="light"] .menu-item.parent-accordion .menu-title {
        color: #5e6278;
        font-weight: 500;
    }

    /* Common hover effects */
    .menu-item.active:hover,
    .menu-item.parent-accordion:hover {
        transition: all 0.3s ease;
    }

    /* Add subtle transition for smooth state changes */
    .menu-item {}
</style>
