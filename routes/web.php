<?php

use App\Http\Controllers\DemoClientController;
use App\Http\Controllers\DesignBriefController;
use App\Http\Controllers\DesignJobController;
use App\Http\Controllers\PaymentController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/demo/client', [DemoClientController::class, 'index'])->middleware('auth')->name('demo.client.index');

    //Payfast
    Route::post('/payfast/form', [PaymentController::class, 'getPaymentFormDetails'])->middleware('auth')->name('payfast.form');
    Route::post('/payfast/checkout', [PaymentController::class, 'checkout'])->middleware('auth')->name('payfast.checkout');
    Route::get('/payfast/success', [PaymentController::class, 'showSuccess'])->middleware('auth')->name('payfast.success');

    //Design Brief

    Route::resource('design_brief', DesignBriefController::class)->middleware('auth')
        ->only(['index','store']);

    //Design Job
    Route::resource('design_job', DesignJobController::class)->middleware('auth')
        ->only(['index','store']);


});
