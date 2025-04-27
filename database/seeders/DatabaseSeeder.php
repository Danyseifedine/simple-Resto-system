<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\TankUseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = \App\Models\Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Administrator with full access to all features'
        ]);

        $userRole = \App\Models\Role::create([
            'name' => 'user',
            'display_name' => 'Regular User',
            'description' => 'Regular user with limited access'
        ]);


        // Create dashboard access permission
        $accessDashboard = \App\Models\Permission::create([
            'name' => 'access-dashboard',
            'display_name' => 'Access Dashboard',
            'description' => 'Can access the dashboard'
        ]);

        // Create user permissions
        $userViewAll = \App\Models\Permission::create([
            'name' => 'user-view-all',
            'display_name' => 'View All Users',
            'description' => 'Can view all users in the system'
        ]);

        $userEdit = \App\Models\Permission::create([
            'name' => 'user-edit',
            'display_name' => 'Edit User',
            'description' => 'Can edit user information'
        ]);

        $userDelete = \App\Models\Permission::create([
            'name' => 'user-delete',
            'display_name' => 'Delete User',
            'description' => 'Can delete users from the system'
        ]);

        $userCreate = \App\Models\Permission::create([
            'name' => 'user-create',
            'display_name' => 'Create User',
            'description' => 'Can create new users'
        ]);

        $userView = \App\Models\Permission::create([
            'name' => 'user-view',
            'display_name' => 'View User',
            'description' => 'Can view user details'
        ]);

        // Create category permissions
        $categoryViewAll = \App\Models\Permission::create([
            'name' => 'category-view-all',
            'display_name' => 'View All Categories',
            'description' => 'Can view all categories in the system'
        ]);

        $categoryEdit = \App\Models\Permission::create([
            'name' => 'category-edit',
            'display_name' => 'Edit Category',
            'description' => 'Can edit category information'
        ]);

        $categoryDelete = \App\Models\Permission::create([
            'name' => 'category-delete',
            'display_name' => 'Delete Category',
            'description' => 'Can delete categories from the system'
        ]);

        $categoryCreate = \App\Models\Permission::create([
            'name' => 'category-create',
            'display_name' => 'Create Category',
            'description' => 'Can create new categories'
        ]);

        $categoryView = \App\Models\Permission::create([
            'name' => 'category-view',
            'display_name' => 'View Category',
            'description' => 'Can view category details'
        ]);

        // Create event permissions
        $eventViewAll = \App\Models\Permission::create([
            'name' => 'event-view-all',
            'display_name' => 'View All Events',
            'description' => 'Can view all events in the system'
        ]);

        $eventEdit = \App\Models\Permission::create([
            'name' => 'event-edit',
            'display_name' => 'Edit Event',
            'description' => 'Can edit event information'
        ]);

        $eventDelete = \App\Models\Permission::create([
            'name' => 'event-delete',
            'display_name' => 'Delete Event',
            'description' => 'Can delete events from the system'
        ]);

        $eventCreate = \App\Models\Permission::create([
            'name' => 'event-create',
            'display_name' => 'Create Event',
            'description' => 'Can create new events'
        ]);

        $eventView = \App\Models\Permission::create([
            'name' => 'event-view',
            'display_name' => 'View Event',
            'description' => 'Can view event details'
        ]);

        // Create menu permissions
        $menuViewAll = \App\Models\Permission::create([
            'name' => 'menu-view-all',
            'display_name' => 'View All Menus',
            'description' => 'Can view all menus in the system'
        ]);

        $menuEdit = \App\Models\Permission::create([
            'name' => 'menu-edit',
            'display_name' => 'Edit Menu',
            'description' => 'Can edit menu information'
        ]);

        $menuDelete = \App\Models\Permission::create([
            'name' => 'menu-delete',
            'display_name' => 'Delete Menu',
            'description' => 'Can delete menus from the system'
        ]);

        $menuCreate = \App\Models\Permission::create([
            'name' => 'menu-create',
            'display_name' => 'Create Menu',
            'description' => 'Can create new menus'
        ]);

        $menuView = \App\Models\Permission::create([
            'name' => 'menu-view',
            'display_name' => 'View Menu',
            'description' => 'Can view menu details'
        ]);

        // Create contact permissions
        $contactViewAll = \App\Models\Permission::create([
            'name' => 'contact-view-all',
            'display_name' => 'View All Contacts',
            'description' => 'Can view all contacts in the system'
        ]);

        $contactEdit = \App\Models\Permission::create([
            'name' => 'contact-edit',
            'display_name' => 'Edit Contact',
            'description' => 'Can edit contact information'
        ]);

        $contactDelete = \App\Models\Permission::create([
            'name' => 'contact-delete',
            'display_name' => 'Delete Contact',
            'description' => 'Can delete contacts from the system'
        ]);

        $contactCreate = \App\Models\Permission::create([
            'name' => 'contact-create',
            'display_name' => 'Create Contact',
            'description' => 'Can create new contacts'
        ]);

        $contactView = \App\Models\Permission::create([
            'name' => 'contact-view',
            'display_name' => 'View Contact',
            'description' => 'Can view contact details'
        ]);

        // Attach all permissions to admin role
        $adminRole->givePermissions([
            $accessDashboard,
            $userViewAll,
            $userEdit,
            $userDelete,
            $userCreate,
            $userView,
            $categoryViewAll,
            $categoryEdit,
            $categoryDelete,
            $categoryCreate,
            $categoryView,
            $eventViewAll,
            $eventEdit,
            $eventDelete,
            $eventCreate,
            $eventView,
            $menuViewAll,
            $menuEdit,
            $menuDelete,
            $menuCreate,
            $menuView,
            $contactViewAll,
            $contactEdit,
            $contactDelete,
            $contactCreate,
            $contactView,
        ]);


        // Create admin user
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $adminUser->addRole($adminRole);

        // Create regular user
        $regularUser = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $regularUser->addRole($userRole);

        // Seed categories and menus
        $categories = [
            [
                'name' => 'Appetizers',
                'menus' => [
                    ['name' => 'Garlic Bread', 'description' => 'Freshly baked bread with garlic butter', 'price' => 5.99],
                    ['name' => 'Mozzarella Sticks', 'description' => 'Breaded mozzarella with marinara sauce', 'price' => 7.99],
                ]
            ],
            [
                'name' => 'Main Courses',
                'menus' => [
                    ['name' => 'Grilled Salmon', 'description' => 'Fresh salmon with lemon butter sauce', 'price' => 18.99],
                    ['name' => 'Beef Steak', 'description' => 'Prime cut beef with vegetables', 'price' => 22.99],
                    ['name' => 'Chicken Alfredo', 'description' => 'Creamy pasta with grilled chicken', 'price' => 16.99],
                    ['name' => 'Vegetable Lasagna', 'description' => 'Layered pasta with seasonal vegetables', 'price' => 14.99],
                ]
            ],
            [
                'name' => 'Desserts',
                'menus' => [
                    ['name' => 'Chocolate Cake', 'description' => 'Rich chocolate cake with ganache', 'price' => 6.99],
                    ['name' => 'Cheesecake', 'description' => 'New York style cheesecake', 'price' => 7.99],
                ]
            ],
            [
                'name' => 'Beverages',
                'menus' => [
                    ['name' => 'Fresh Lemonade', 'description' => 'Homemade lemonade with mint', 'price' => 3.99],
                    ['name' => 'Iced Tea', 'description' => 'Freshly brewed tea with lemon', 'price' => 2.99],
                    ['name' => 'Coffee', 'description' => 'Premium blend coffee', 'price' => 3.49],
                ]
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = \App\Models\Category::create([
                'name' => $categoryData['name']
            ]);

            foreach ($categoryData['menus'] as $menuData) {
                $menu = \App\Models\Menu::create([
                    'name' => $menuData['name'],
                    'description' => $menuData['description'],
                    'price' => $menuData['price'],
                    'category_id' => $category->id
                ]);
            }
        }

        // Seed events
        $events = [
            [
                'title' => 'Weekend Special Brunch',
                'description' => 'Join us for a special weekend brunch featuring our chef\'s signature dishes.',
                'start_date' => now()->addDays(3)->setTime(10, 0),
                'end_date' => now()->addDays(3)->setTime(14, 0),
            ],
            [
                'title' => 'Wine Tasting Evening',
                'description' => 'Sample our finest selection of wines paired with gourmet appetizers.',
                'start_date' => now()->addDays(7)->setTime(18, 0),
                'end_date' => now()->addDays(7)->setTime(21, 0),
            ],
            [
                'title' => 'Live Music Night',
                'description' => 'Enjoy dinner with live acoustic performances from local artists.',
                'start_date' => now()->addDays(14)->setTime(19, 0),
                'end_date' => now()->addDays(14)->setTime(23, 0),
            ],
            [
                'title' => 'Cooking Class',
                'description' => 'Learn to prepare our most popular dishes with our head chef.',
                'start_date' => now()->addDays(21)->setTime(15, 0),
                'end_date' => now()->addDays(21)->setTime(17, 0),
            ],
        ];

        foreach ($events as $eventData) {
            \App\Models\Event::create($eventData);
        }
    }
}
