<?php

use App\Http\Controllers\API\CalendarController;
use App\Http\Controllers\API\DebtController;
use App\Http\Controllers\API\LocationController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\OnProgressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/store-notification', [NotificationController::class, 'store'])->name('apiStoreNotification');
Route::get('/get-notification', [NotificationController::class, 'getNotification'])->name('apiGetNotification');
Route::get('/delete-notification/{notification_id}', [NotificationController::class, 'deleteNotification'])->name('apiDeleteNotification');
Route::get('/delete-all-notification', [NotificationController::class, 'deleteAllNotification'])->name('apiDeleteAllNotification');

Route::get('/get-provinces', [LocationController::class, 'provinces'])->name('apiGetProvinces');
Route::get('/get-cities/{provinces_id}', [LocationController::class, 'cities'])->name('apiGetCities');
Route::get('/get-districts/{cities_id}', [LocationController::class, 'districts'])->name('apiGetDistricts');
Route::get('/get-villages/{districts_id}', [LocationController::class, 'villages'])->name('apiGetVillages');

Route::get('/get-project/{project_id}/{kind}', [OnProgressController::class, 'project'])->name('apiGetProject');

Route::get('/get-billing/{project_id}/{kind}', [OnProgressController::class, 'billing'])->name('apiGetBilling');
Route::get('/get-termin/{project_id}/{kind}', [OnProgressController::class, 'termin'])->name('apiGetTermin');

Route::post('/store-billing', [OnProgressController::class, 'storeBilling'])->name('apiStoreBilling');
Route::post('/store-termin', [OnProgressController::class, 'storeTermin'])->name('apiStoreTermin');
Route::post('/store-sharing', [OnProgressController::class, 'storeSharing'])->name('apiStoreSharing');

Route::get('/get-sharing/{project_id}/{kind}', [OnProgressController::class, 'sharing'])->name('apiGetSharing');
Route::get('/get-weekly-bills/{project_id}/{date}', [OnProgressController::class, 'weeklyBills'])->name('apiGetWeeklyBills');

Route::get('/get-event-calendar', [CalendarController::class, 'eventCalendar'])->name('apiGetEventCalendar');

    