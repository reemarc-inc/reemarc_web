<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\dummyApi;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ClinicController;
use App\Http\Controllers\Admin\AppointmentsController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PackageController;
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

Route::group(['middleware' => 'auth:sanctum'], function(){
    //All secure URL's
    Route::get('data', [dummyApi::class, 'getData']);
//    Route::apiResource("member", MemberController::class);
});

Route::post('log_in', [UserController::class, 'log_in']); //
Route::post('sign_up', [UserController::class, 'api_sign_up']); //

Route::get('get_member', [UserController::class, 'get_user_list']); //
Route::post('users_update_app', [UserController::class, 'users_update_app']); //
Route::post('get_me', [UserController::class, 'get_me']);

Route::get("get_clinic_list", [ClinicController::class, 'get_clinic_list']); //
Route::post("get_appointments_upcoming_list", [AppointmentsController::class, 'get_appointments_upcoming_list']); //
Route::post("get_appointments_complete_list", [AppointmentsController::class, 'get_appointments_complete_list']); //


Route::post("get_appointments_upcoming_list_profile", [AppointmentsController::class, 'get_appointments_upcoming_list_profile']); //
Route::post("get_appointments_complete_list_profile", [AppointmentsController::class, 'get_appointments_complete_list_profile']); //
Route::post("get_appointments_cancel_list_profile", [AppointmentsController::class, 'get_appointments_cancel_list_profile']); //

Route::post("booking_from_app", [AppointmentsController::class, 'booking_from_app']); //
Route::post("booking_cancel_app", [AppointmentsController::class, 'booking_cancel_app']); //

Route::post("treatment_booking", [AppointmentsController::class, 'treatment_booking']);

Route::post("get_notification_list", [NotificationController::class, 'get_notification_list']); //
Route::post("delete_notification", [NotificationController::class, 'delete_notification']); //
Route::post("read_notification", [NotificationController::class, 'read_notification']);

Route::post("location_confirm", [NotificationController::class, 'location_confirm']); //
Route::post("confirm_your_visit", [NotificationController::class, 'confirm_your_visit']); //
Route::post('get_package_by_treatment_id', [PackageController::class, 'get_package_by_treatment_id']);

Route::apiResource("member", MemberController::class);
