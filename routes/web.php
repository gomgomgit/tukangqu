<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\SurveyNotificationController;
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
    return redirect()->route('admin.login');
});

Route::get('/surveynotify',[SurveyNotificationController::class, 'surveynotify'])->name('surveyNotification');
Route::view('/survey-notification', 'admin.notification.survey-notification');

Route::get('/create-project', [VisitorController::class, 'createProject'])->name('createProject');
Route::post('/create-project-process', [VisitorController::class, 'createProjectProcess'])->name('createProjectProcess');
Route::get('/create-project-sucess', [VisitorController::class, 'createProjectSucess'])->name('createProjectSucess');

Route::get('/worker-register', [VisitorController::class, 'workerRegister'])->name('workerRegister');
Route::post('/worker-register-process', [VisitorController::class, 'workerRegisterProcess'])->name('workerRegisterProcess');
Route::get('/worker-register-sucess', [VisitorController::class, 'workerRegisterSucess'])->name('workerRegisterSucess');

Route::prefix('/admin')->name('admin.')->group(function() {
    Route::get('/', function () {
        return redirect(route('admin.login'));
    });

    Route::group(['middleware' => ['guest']], function () {
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/login-process', [AuthController::class, 'loginProcess'])->name('loginProcess');
    });
    
    Route::group(['middleware' => ['auth']], function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/schedules', [DashboardController::class, 'dashboardSchedules'])->name('dashboardSchedules');

        Route::get('/report', [ReportController::class, 'index'])->name('report');
        Route::get('/report/today-survey', [ReportController::class, 'todaySurvey'])->name('reportTodaySurvey');

        Route::resource('workers', WorkerController::class);
        // Route::resource('projects', ProjectController::class);

        Route::prefix('/projects')->name('projects.')->group( function() {
            Route::get('/create', [ProjectController::class, 'create'])->name('create');
            Route::post('/store', [ProjectController::class, 'store'])->name('store');
            Route::get('/edit/{id}/{kind}', [ProjectController::class, 'edit'])->name('edit');
            Route::post('/update/{id}/{kind}', [ProjectController::class, 'update'])->name('update');

            Route::get('/on-process/{kind?}', [ProjectController::class, 'onProcess'])->name('onProcess');
            Route::get('/on-process/{id}/show/{kind?}', [ProjectController::class, 'onProcessShow'])->name('onProcessShow');
            Route::post('/on-process/{id}/scheduling/{kind?}', [ProjectController::class, 'scheduling'])->name('scheduling');
            Route::post('/on-process/{id}/pricing/{kind?}', [ProjectController::class, 'pricing'])->name('pricing');
            Route::get('/on-process/{id}/dealing/{kind?}', [ProjectController::class, 'dealing'])->name('dealing');
            Route::post('/on-process/{id}/deal/{kind?}', [ProjectController::class, 'deal'])->name('deal');
            Route::get('/on-process/{id}/failed/{kind?}', [ProjectController::class, 'failed'])->name('failed');
            
            Route::get('/on-progress/{kind?}', [ProjectController::class, 'onProgress'])->name('onProgress');
            Route::post('/on-progress/{id}/add-billing/{kind?} ', [ProjectController::class, 'addBilling'])->name('addBilling');
            Route::post('/on-progress/{id}/add-payment-fee/{kind?} ', [ProjectController::class, 'addTermin'])->name('addTermin');
            Route::post('/on-progress/{id}/add-profit/{kind?} ', [ProjectController::class, 'addProfit'])->name('addProfit');
            Route::post('/on-progress/{id}/done/{kind?} ', [ProjectController::class, 'done'])->name('done');
            Route::get('/on-progress/{id}/finish/{kind?}', [ProjectController::class, 'finish'])->name('finish');
            Route::get('/on-progress/{id}/show/{kind?}', [ProjectController::class, 'onProgressShow'])->name('onProgressShow');
            
            Route::get('/finished/{kind?}', [ProjectController::class, 'finished'])->name('finished');
            Route::get('/finished/{id}/show/{kind?}', [ProjectController::class, 'finishedShow'])->name('finishedShow');
            
            Route::delete('/destroy/{id}/{kind?}', [ProjectController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('/cashes')->name('cashes.')->group(function() {
            Route::get('/', [CashController::class, 'index'])->name('index');
            Route::get('/create-out', [CashController::class, 'createOut'])->name('createOut');
            Route::post('/store-out', [CashController::class, 'storeOut'])->name('storeOut');
            Route::post('/store-in', [CashController::class, 'storeIn'])->name('storeIn');
            Route::get('/edit/{id}', [CashController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [CashController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [CashController::class, 'destroy'])->name('destroy');
        });

    });
});


Route::get('/laravel', function () {
    return view('laravel');
});
