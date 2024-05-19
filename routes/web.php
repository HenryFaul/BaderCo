<?php

use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DemoClientController;
use App\Http\Controllers\DesignBriefController;
use App\Http\Controllers\DesignJobController;
use App\Http\Controllers\DesignJobEventController;
use App\Http\Controllers\FileStoreController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RoleModifyController;
use App\Http\Controllers\UserAssignController;
use App\Http\Controllers\UserDetailController;
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

   /* Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');*/

    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
    Route::get('/art', [ArtworkController::class, 'index'])->middleware('auth')->name('art');



    Route::get('/demo/client', [DemoClientController::class, 'index'])->middleware('auth')->name('demo.client.index');

    //Payfast
    Route::post('/payfast/form', [PaymentController::class, 'getPaymentFormDetails'])->middleware('auth')->name('payfast.form');
    Route::post('/payfast/checkout', [PaymentController::class, 'checkout'])->middleware('auth')->name('payfast.checkout');
    Route::get('/payfast/success/{job_id?}', [PaymentController::class, 'showSuccess'])->middleware('auth')->name('payfast.success');


    //User Detail

    Route::resource('user_detail', UserDetailController::class)->middleware('auth')
        ->only(['index','store','show','update']);

    Route::post('/user_detail/update_cv', [UserDetailController::class, 'updateCustom'])->middleware('auth')->name('user_detail.update.cv');

    //Design Job Event

    Route::resource('design_job_event', DesignJobEventController::class)->middleware('auth')
        ->only(['index']);

    //Design Brief

    Route::resource('design_brief', DesignBriefController::class)->middleware('auth')
        ->only(['index','store']);

    //Design Job
    Route::resource('design_job', DesignJobController::class)->middleware('auth')
        ->only(['index','store','create','show']);

    Route::put('/design_job_status/update/{design_job}', [DesignJobController::class, 'updateStatus'])->middleware('auth')->name('design_job_status.update');
    Route::put('/design_job_payment/update/{design_job}', [DesignJobController::class, 'updatePaymentStatus'])->middleware('auth')->name('design_job_payment.update');


    //User Assign

    Route::put('/user_assign/creator/{design_job}', [UserAssignController::class, 'assignCreator'])->middleware('auth')->name('user_assign.creator');
    Route::put('/user_assign/pm/{design_job}', [UserAssignController::class, 'assignPm'])->middleware('auth')->name('user_assign.pm');


    //FileStore
    Route::resource('file_store', FileStoreController::class)->middleware('auth')
        ->only(['store','update']);

    Route::get('/file_store/download/{file_name}', [FileStoreController::class, 'download'])->middleware('auth')->name('file_store.download');
    Route::get('/file_store/download2/{file_name}', [FileStoreController::class, 'download2'])->middleware('auth')->name('file_store.download2');

   // Route::get('/download-file/{filename}', 'FileController@download')->name('download.file');


    //Modify User roles

    Route::post('/roles/modify', [RoleModifyController::class, 'store'])->middleware('auth')->name('roles.modify.store');
    Route::put('/roles/modify', [RoleModifyController::class, 'destroy'])->middleware('auth')->name('roles.modify.destroy');



});
