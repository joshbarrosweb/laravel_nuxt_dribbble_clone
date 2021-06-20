<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

use App\Http\Controllers\User\MeController;
use App\Http\Controllers\User\SettingsController;
use App\Http\Controllers\Designs\UploadController;
use App\Http\Controllers\Designs\DesignController;

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

Route::get('me', [MeController::class, 'getMe']);

Route::group(['middleware' => ['auth:api']], function () {
	Route::post('logout', [LoginController::class, 'logout']);
	Route::put('settings/profile', [SettingsController::class, 'updateProfile']);
	Route::put('settings/password', [SettingsController::class, 'updatePassword']);
	
	Route::post('designs', [UploadController::class, 'upload']);
	Route::put('designs/{id}', [DesignController::class, 'update']);
	Route::delete('designs/{id}', [DesignController::class, 'destroy']);
});

Route::group(['middleware' => ['guest:api']], function () {
	Route::post('register', [RegisterController::class, 'register']);
	Route::post('verification/verify/{user}', [VerificationController::class, 'verify'])->name('verification.verify');
	Route::post('verification/resend', [VerificationController::class, 'resend']);

	Route::post('login', [LoginController::class, 'login']);

	Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail']);
	Route::post('password/reset', [ResetPasswordController::class,'reset']);
});