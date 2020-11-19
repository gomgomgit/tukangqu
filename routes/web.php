<?php

use App\Http\Controllers\CashController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\WorkerController;
use Illuminate\Support\Facades\Route;

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
    return view('example');
});

Route::prefix('/admin')->name('admin.')->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('workers', WorkerController::class);
    // Route::resource('projects', ProjectController::class);

    Route::prefix('/projects')->name('projects.')->group( function() {
        Route::get('/create', [ProjectController::class, 'create'])->name('create');
        Route::post('/store', [ProjectController::class, 'store'])->name('store');
        Route::get('/on-process/{kind?}', [ProjectController::class, 'onProcess'])->name('onProcess');
        Route::get('/on-process/{id}/show/{kind?}', [ProjectController::class, 'onProcessShow'])->name('onProcessShow');
        Route::post('/on-process/{id}/scheduling/{kind?}', [ProjectController::class, 'scheduling'])->name('scheduling');
        Route::post('/on-process/{id}/pricing/{kind?}', [ProjectController::class, 'pricing'])->name('pricing');
        Route::get('/on-process/{id}/dealing/{kind?}', [ProjectController::class, 'dealing'])->name('dealing');
        Route::post('/on-process/{id}/deal/{kind?}', [ProjectController::class, 'deal'])->name('deal');
        Route::get('/on-process/{id}/failed/{kind?}', [ProjectController::class, 'failed'])->name('failed');
        Route::get('/on-progress/{kind?}', [ProjectController::class, 'onProgress'])->name('onProgress');
        Route::get('/finished/{kind?}', [ProjectController::class, 'finished'])->name('finished');
        Route::delete('/destroy/{id}/{kind?}', [ProjectController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('/cashes')->name('cashes.')->group(function() {
        Route::get('/', [CashController::class, 'index'])->name('index');
        Route::get('/create-out', [CashController::class, 'createOut'])->name('createOut');
        Route::post('/store-out', [CashController::class, 'storeOut'])->name('storeOut');
        Route::post('/store-in', [CashController::class, 'storeIn'])->name('storeIn');
        Route::delete('/destroy/{id}', [CashController::class, 'destroy'])->name('destroy');
    });
});


Route::get('/laravel', function () {
    return view('laravel');
});
