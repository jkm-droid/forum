<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiteController;
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

Route::get('/', [SiteController::class, 'show_welcome_page'])->name('site.home');
Route::get('/category/forum/{slug}', [SiteController::class, 'show_single_category'])->name('site.single.category');
Route::get('/topic/forum/{slug}', [SiteController::class, 'show_topic'])->name('site.single.topic');

/**
 * user authentication
 * */
Route::get('user/login', [AuthController::class, 'show_login_page'])->name('show.login');
Route::post('login', [AuthController::class, 'login'])->name('user.login');
Route::get('user/register', [AuthController::class, 'show_register_page'])->name('show.register');
Route::post('register', [AuthController::class, 'register'])->name('user.register');
Route::get('logout', [AuthController::class, 'logout'])->name('user.logout');
Route::get('user/forgot_pass', [AuthController::class, 'show_forgot_pass_form'])->name('user.show.forgot_pass_form');
Route::post('forgot_pass', [AuthController::class, 'submit_forgot_pass_form'])->name('user.forgot_submit');
Route::get('user/reset_pass/{token}', [AuthController::class, 'show_reset_pass_form'])->name('user.show.reset_form');
Route::post('reset_pass', [AuthController::class, 'reset_pass'])->name('user.reset_pass');
