<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CashController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\SurveyNotificationController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
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
Route::get('/surveydaynotify',[SurveyNotificationController::class, 'surveydaynotify'])->name('surveyDayNotification');
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
        Route::get('/test', [TestController::class, 'log'])->name('testLog');
        Route::get('/check', [TestController::class, 'checklog'])->name('checkLog');

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/schedules', [DashboardController::class, 'dashboardSchedules'])->name('dashboardSchedules');

        Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');

        Route::prefix('/report')->name('report.')->group( function() {
            Route::get('/', [ReportController::class, 'index'])->name('index');
            // Route::get('/report/today-survey', [ReportController::class, 'todaySurvey'])->name('reportTodaySurvey');
            Route::get('/view-projects/{id}', [ReportController::class, 'viewProjects'])->name('viewProjects');
        });

        Route::resource('workers', WorkerController::class);
        Route::get('/workers/view-projects/{id}', [WorkerController::class, 'viewProjects'])->name('workers.viewProjects');
        Route::get('/workers/project-show/{id}/{kind}', [WorkerController::class, 'projectShow'])->name('workers.projectShow');
        // Route::resource('projects', ProjectController::class);

        Route::resource('clients', ClientController::class);
        Route::get('/clients/view-projects/{id}', [ClientController::class, 'viewProjects'])->name('clients.viewProjects');

        Route::resource('users', UserController::class);

        Route::prefix('/projects')->name('projects.')->group( function() {
            Route::get('/create', [ProjectController::class, 'create'])->name('create');
            Route::post('/store', [ProjectController::class, 'store'])->name('store');
            Route::get('/edit/{id}/{kind}', [ProjectController::class, 'edit'])->name('edit');
            Route::post('/update/{id}/{kind}', [ProjectController::class, 'update'])->name('update');

            Route::get('/worker-show/{id}', [ProjectController::class, 'workerShow'])->name('workerShow');
            Route::get('/worker-show-projects/{id}', [ProjectController::class, 'workerShowProjects'])->name('workerShowProjects');

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
            Route::post('/finished/{id}/refund/{kind?}', [ProjectController::class, 'finishedRefund'])->name('finishedRefund');
            
            Route::delete('/destroy/{id}/{kind?}', [ProjectController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('/cashes')->name('cashes.')->group(function() {
            Route::get('/', [CashController::class, 'index'])->name('index');

            Route::get('/debt', [CashController::class, 'debt'])->name('debt');
            Route::get('/debt/detail/{id}', [CashController::class, 'debtDetail'])->name('debtDetail');
            Route::post('/debt/pay', [CashController::class, 'debtPay'])->name('debtPay');

            Route::get('/create-out', [CashController::class, 'createOut'])->name('createOut');
            Route::post('/store-out', [CashController::class, 'storeOut'])->name('storeOut');
            Route::post('/store-in', [CashController::class, 'storeIn'])->name('storeIn');
            Route::get('/editout/{id}', [CashController::class, 'editout'])->name('editout');
            Route::get('/editin/{id}', [CashController::class, 'editin'])->name('editin');
            Route::put('/updatein/{id}', [CashController::class, 'updatein'])->name('updatein');
            Route::put('/updateout/{id}', [CashController::class, 'updateout'])->name('updateout');
            Route::delete('/destroy/{id}', [CashController::class, 'destroy'])->name('destroy');

            Route::get('/project-show/{id}/{kind}', [CashController::class, 'projectShow'])->name('projectShow');

            Route::get('/export/out/{month}', [CashController::class, 'exportOut'])->name('exportOut');
            Route::get('/export/in/{month}', [CashController::class, 'exportIn'])->name('exportIn');
            Route::get('/export/debt/{month}', [CashController::class, 'exportDebt'])->name('exportDebt');
            
            Route::get('/export-view/out/{month?}', [CashController::class, 'exportViewOut'])->name('exportViewOut');
            Route::get('/export-view/in/{month?}', [CashController::class, 'exportViewIn'])->name('exportViewIn');
            Route::get('/export-view/debt/{month?}', [CashController::class, 'exportViewDebt'])->name('exportViewDebt');

            Route::get('/export-template/out', [CashController::class, 'exportTemplateOut'])->name('exportTemplateOut');
            Route::get('/export-template/in', [CashController::class, 'exportTemplateIn'])->name('exportTemplateIn');
            
            Route::get('/export-template-view/out', [CashController::class, 'exportTemplateViewOut'])->name('exportTemplateViewOut');
            Route::get('/export-template-view/in', [CashController::class, 'exportTemplateViewIn'])->name('exportTemplateViewIn');

            Route::get('/import', [CashController::class, 'import'])->name('import');
            Route::post('/import/in', [CashController::class, 'importIn'])->name('importIn');
            Route::post('/import/out', [CashController::class, 'importOut'])->name('importOut');
        });

    });
});


Route::get('/laravel', function () {
    return view('laravel');
});


Route::get('/test-pusher', [SurveyNotificationController::class, 'test']);