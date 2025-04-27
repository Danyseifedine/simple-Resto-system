<?php

return [
    'menu_items' => [
        // Dashboard
        [
            'icon' => 'bi bi-grid fs-2',
            'title' => 'Dashboard',
            'link' => 'dashboard.index',
            'is_route' => true,
        ],

        // Section Title
        [
            'is_heading' => true,
            'title' => 'common.dashboard.pages',
        ],

        // User Profile Menu
        [
            'icon' => 'bi bi-people-fill fs-2',
            'title' => 'Users',
            'link' => 'dashboard.users.index',
            'is_route' => true,
            'permissions' => ["user-view-all"],
        ],
        [
            'icon' => 'bi bi-tags-fill fs-2',
            'title' => 'Categories',
            'link' => 'dashboard.categories.index',
            'is_route' => true,
            'permissions' => ["category-view-all"],
        ],
        [
            'icon' => 'bi bi-calendar-event-fill fs-2',
            'title' => 'Events',
            'link' => 'dashboard.events.index',
            'is_route' => true,
            'permissions' => ["event-view-all"],
        ],

        [
            'icon' => 'bi bi-list-nested fs-2',
            'title' => 'Menu',
            'link' => 'dashboard.menus.index',
            'is_route' => true,
            'permissions' => ["menu-view-all"],
        ],
        [
            'icon' => 'bi bi-envelope fs-2',
            'title' => 'Contact Messages',
            'link' => 'dashboard.contacts.index',
            'is_route' => true,
            'permissions' => ["contact-view-all"],
        ],
        [
            'icon' => 'bi bi-envelope-fill fs-2',
            'title' => 'Newsletter',
            'link' => 'dashboard.newsLetters.index',
            'is_route' => true,
            'roles' => ["admin"],
        ],
        // Section Title
        [
            'is_heading' => true,
            'title' => 'Privileges',
            'roles' => ["admin"],
        ],
        [
            'icon' => 'bi bi-lock-fill fs-2',
            'title' => 'Security',
            'route_in' => 'dashboard.privileges.*',
            'roles' => ["admin"],
            'submenu' => [
                [
                    'title' => 'Roles',
                    'link' => 'dashboard.privileges.roles.index',
                    'is_route' => true,
                    'icon' => 'bi bi-person fs-2',

                ],
                [
                    'title' => 'Permission Role',
                    'link' => 'dashboard.privileges.permission-role.index',
                    'is_route' => true,
                    'icon' => 'bi bi-person fs-2'
                ],
                [
                    'title' => 'User Role',
                    'link' => 'dashboard.privileges.roles.users.index',
                    'is_route' => true,
                    'icon' => 'bi bi-person fs-2'
                ],
                [
                    'title' => 'User Permission',
                    'link' => 'dashboard.privileges.permissions.users.index',
                    'is_route' => true,
                    'icon' => 'bi bi-person fs-2'
                ],

            ]
        ],
    ],
];
