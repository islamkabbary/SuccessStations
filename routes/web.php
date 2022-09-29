<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UniversityController;

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

Auth::routes();
Route::get('privacy', [SettingController::class, 'getPrivacy'])->name('privacy.policy');
Route::get('terms', [SettingController::class, 'getTerms'])->name('terms');
// Route::get('forget/password/get', [UserController::class, 'forgetPasswordView'])->name('forget.password.get');
// Route::post('send/code', [UserController::class, 'sendCode'])->name('send.code');
// Route::get('check/code/get', [UserController::class, 'checkCodeView'])->name('check.code.get');
// Route::post('check/code/post', [UserController::class, 'checkCode'])->name('check.code.post');
// Route::get('forget/password/view', [UserController::class, 'resetPasswordView'])->name('forget.password.view');
// Route::post('forget/password/post', [UserController::class, 'resetPassword'])->name('forget.password.post');
Route::group(['middleware' => ['lang', 'auth']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::resource('users', UserController::class);
    Route::resource('countries', CountryController::class);
    Route::resource('universities', UniversityController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('ads', AdsController::class);
    
    Route::get('settings', [SettingController::class, 'settings'])->name('settings');
    Route::post('settings/update', [SettingController::class, 'update'])->name('settings.update');
    Route::get('settings/change_lang/{lang}', [SettingController::class, 'changeLang'])->name('settings.changelang');
    Route::get('user/profile', [UserController::class, 'showUserProfile'])->name('user.profile');
    Route::put('user/profile/update', [UserController::class, 'updateUserProfile'])->name('user.profile.update');
    Route::get('update/password', [UserController::class, 'updatePasswordView'])->name('update.password');
    Route::post('update/password/post', [UserController::class, 'updatePassword'])->name('update.password.post');

    // Route::resource('cities', CityController::class);
    // Route::resource('markets', MarketController::class);
    // Route::resource('products', ProductController::class);
    // Route::resource('promo_codes', PromoCodeController::class);
    // Route::resource('brands', BrandController::class);
    // Route::resource('orders', OrderController::class);
    // Route::get('orders/pdf/{id}', [OrderController::class, 'pdf'])->name('orders.pdf');
    // Route::post('change/status/users/{id}', [UserController::class, 'changeStatus'])->name('users.changeStatus');

    Route::resource('notifications', NotificationController::class, ['except' => ['edit', 'update']]);
});
