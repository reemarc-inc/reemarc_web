<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\dummyApi;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Admin\UserController;
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

Route::get('login', [LoginController::class, 'index']);
//Route::post('sing_up', [UserController::class, 'api_sign_up']);

Route::post('sign_up', [UserController::class, 'api_sign_up']);

Route::apiResource("member", MemberController::class);
