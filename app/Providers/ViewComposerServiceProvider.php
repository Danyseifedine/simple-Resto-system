<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laratrust\Laratrust;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('dashboard.common.navbar', function ($view) {
            $user = Auth::user();
            $notifications = collect([]);
            $unreadCount = 0;

            // Only share notifications with admin users
            if ($user && app('laratrust')->hasRole('admin', $user)) {
                $notifications = Notification::latest()->take(5)->get();
                $unreadCount = Notification::whereNull('read_at')->count();
            }

            $view->with('notifications', $notifications);
            $view->with('unreadCount', $unreadCount);
        });
    }
}
