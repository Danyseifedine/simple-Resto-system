<?php

use App\Http\Controllers\Auth\LoginController;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Event;
use App\Models\NewsLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;



if (config('app.features.multi_lang')) {
    Route::group([
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ], function () {
        defineRoutes();
    });
} else {
    defineRoutes();
}


function defineRoutes()
{
    Route::get('/', function () {
        return view('web.home');
    })->name('welcome');

    Route::post("/newsletter", function (Request $request) {
        $request->validate([
            'email' => 'required|email|unique:news_letters,email',
        ]);
        NewsLetter::create($request->all());
        return redirect()->back()->with('success', 'You have been subscribed to our newsletter');
    })->name('newsletter.store');

    Route::post("/contact", function (Request $request) {
        $request->validate([
            'message' => 'required',
            'subject' => 'required',
        ]);
        Contact::create($request->all());
        return redirect()->back()->with('success', 'You have been subscribed to our newsletter');
    })->name('contact.store');

    Route::get("/about", function () {
        return view('web.about');
    })->name('about');

    Route::get("/contact", function () {
        return view('web.contact');
    })->name('contact');

    Route::get("/menu", function () {
        $menus = Menu::all();
        $categories = Category::all();
        return view('web.menu', compact('menus', 'categories'));
    })->middleware('auth')->name('menu');

    Route::get("/faq", function () {
        return view('web.faq');
    })->middleware('auth')->name('faq');

    Route::get("/events", function () {
        $events = Event::all();
        return view('web.events', compact('events'));
    })->name('events');


    // Auth routes
    Auth::routes(['verify' => true]);

    // Logout route
    Route::middleware(['auth'])->group(function () {
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    });

    Route::middleware(['verified'])->group(function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        include __DIR__ . DIRECTORY_SEPARATOR . 'dashboard.php';
    });
}
