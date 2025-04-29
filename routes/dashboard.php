<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\Pages\UserController;
// datatable controller
use Illuminate\Support\Facades\Route;
// Datatable Controllers
use App\Http\Controllers\Dashboard\Pages\BillingsController;
use App\Http\Controllers\Dashboard\Pages\NewsLetterController;
use App\Http\Controllers\Dashboard\Pages\ContactController;
use App\Http\Controllers\Dashboard\Pages\MenuController;
use App\Http\Controllers\Dashboard\Pages\EventController;
use App\Http\Controllers\Dashboard\Pages\CategoryController;
use App\Http\Controllers\Dashboard\Pages\ContactMessageController;
use App\Http\Controllers\Dashboard\Pages\TankController;
use App\Http\Controllers\Dashboard\Pages\TankTypeController;
use App\Http\Controllers\Dashboard\Pages\TankUseController;
use App\Http\Controllers\Dashboard\Pages\DeliveryLogController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\ProfileController;



Route::prefix('dashboard')->middleware('permission:access-dashboard')->name('dashboard.')->group(function () {

    // Dashboard routes
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/analytics', 'analytics')->name('analytics.index');
    });

    // Notification routes
    Route::controller(NotificationController::class)->prefix('notifications')->name('notifications.')->middleware('role:admin')->group(function () {
        Route::get('/mark-as-read/{id}', 'markAsRead')->name('mark-as-read');
        Route::get('/mark-all-read', 'markAllAsRead')->name('mark-all-read');
        Route::get('/delete/{id}', 'delete')->name('delete');
        Route::get('/clear-all', 'clearAll')->name('clear-all');
    });

    // ======================================================================= //
    // ====================== START USER DATATABLE =========================== //
    // ======================================================================= //

    Route::controller(UserController::class)->prefix("users")->name("users.")->group(function () {
        Route::post('/update', 'update')->name('update');
        Route::get('/{id}/show', 'show')->name('show');
        Route::get('/datatable', 'datatable')->name('datatable');
        Route::patch('/{id}/status', 'status')->name('status');
    });
    Route::resource('users', UserController::class)->except(['show', 'update']);

    // ======================================================================= //
    // ====================== END USER DATATABLE ============================= //
    // ======================================================================= //


    // ======================================================================= //
    // ====================== END CONTACTMESSAGE DATATABLE =================== //

    // ======================================================================= //
    // ====================== START CATEGORY DATATABLE =========================== //
    // ======================================================================= //

    Route::controller(CategoryController::class)
        ->prefix('categories')
        ->name('categories.')
        ->group(function () {
            Route::post('/update', 'update')->name('update');
            Route::get('/{id}/show', 'show')->name('show');
            Route::get('/datatable', 'datatable')->name('datatable');
        });

    Route::resource('categories', CategoryController::class)
        ->except(['show', 'update']);

    // ======================================================================= //
    // ====================== END CATEGORY DATATABLE ========================= //
    // ======================================================================= //

    // ======================================================================= //
    // ====================== START EVENT DATATABLE ========================== //
    // ======================================================================= //

    Route::controller(EventController::class)
        ->prefix('events')
        ->name('events.')
        ->group(function () {
            Route::post('/update', 'update')->name('update');
            Route::get('/{id}/show', 'show')->name('show');
            Route::get('/datatable', 'datatable')->name('datatable');
        });

    Route::resource('events', EventController::class)
        ->except(['show', 'update']);

    // ======================================================================= //
    // ====================== END EVENT DATATABLE =========================== //
    // ======================================================================= //

    // ======================================================================= //
    // ====================== START MENU DATATABLE =========================== //
    // ======================================================================= //

    Route::controller(MenuController::class)
        ->prefix('menus')
        ->name('menus.')
        ->group(function () {
            Route::post('/update', 'update')->name('update');
            Route::get('/{id}/show', 'show')->name('show');
            Route::get('/datatable', 'datatable')->name('datatable');
        });

    Route::resource('menus', MenuController::class)
        ->except(['show', 'update']);

    // ======================================================================= //
    // ======================== END MENU DATATABLE =========================== //
    // ======================================================================= //

    // ======================================================================= //
    // ===================== START CONTACT DATATABLE ========================= //
    // ======================================================================= //

    Route::controller(ContactController::class)
        ->prefix('contacts')
        ->name('contacts.')
        ->group(function () {
            Route::post('/update', 'update')->name('update');
            Route::get('/{id}/show', 'show')->name('show');
            Route::get('/datatable', 'datatable')->name('datatable');
        });

    Route::resource('contacts', ContactController::class)
        ->except(['show', 'update']);

    // ======================================================================= //
    // ====================== END CONTACT DATATABLE ========================== //
    // ======================================================================= //

    // ======================================================================= //
    // =================== START NEWSLETTER DATATABLE ======================== //
    // ======================================================================= //

    Route::controller(NewsLetterController::class)
        ->prefix('newsLetters')
        ->name('newsLetters.')
        ->group(function () {
            Route::post('/update', 'update')->name('update');
            Route::get('/{id}/show', 'show')->name('show');
            Route::get('/datatable', 'datatable')->name('datatable');
        });

    Route::resource('newsLetters', NewsLetterController::class)
        ->except(['show', 'update']);

    // ======================================================================= //
    // ==================== END NEWSLETTER DATATABLE ========================= //

    // ======================================================================= //
    // ====================== START BILLINGS DATATABLE =========================== //
    // ======================================================================= //

    Route::controller(BillingsController::class)
        ->prefix('billings')
        ->name('billings.')
        ->group(function () {
            Route::post('/update', 'update')->name('update');
            Route::get('/{id}/show', 'show')->name('show');
            Route::get('/datatable', 'datatable')->name('datatable');
    });

    Route::resource('billings', BillingsController::class)
        ->except(['show', 'update']);

    // ======================================================================= //
    // ====================== END BILLINGS DATATABLE =========================== //
    // ======================================================================= //
// ======================================================================= //

    // Profile routes
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::patch('/update', 'updateProfile')->name('update');
        Route::patch('/password', 'updatePassword')->name('password');
    });

    include __DIR__ . DIRECTORY_SEPARATOR . 'Privileges.php';
});
