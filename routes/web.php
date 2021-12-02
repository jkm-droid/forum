<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthenticatedSiteController;
use App\Http\Controllers\ProfileController;
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
Route::get('/category/{slug}', [SiteController::class, 'show_single_category'])->name('site.single.category');
Route::get('/topic/{slug}', [SiteController::class, 'show_topic'])->name('site.single.topic');
Route::get('/view/all_categories', [SiteController::class, 'show_all_categories'])->name('site.all.categories');
Route::get('/view/top_topics', [SiteController::class, 'show_top_topics'])->name('site.top.topics');

/**
 * authenticated users
 */
Route::post('/save/message/', [AuthenticatedSiteController::class, 'save_new_message'])->name('site.save.message');
Route::post('/post/reply/', [AuthenticatedSiteController::class, 'save_new_reply'])->name('site.save.reply');
Route::get('/create/new_topic', [AuthenticatedSiteController::class, 'show_create_new_topic_form'])->name('site.show.topic.form');
Route::post('/save/new_topic/', [AuthenticatedSiteController::class, 'save_new_topic'])->name('new.topic.save');
Route::post('/topic/delete', [AuthenticatedSiteController::class, 'delete_topic'])->name('topic.delete');
Route::post('/reply/delete', [AuthenticatedSiteController::class, 'delete_reply'])->name('reply.delete');


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


/**
 * user profile
 * */
Route::get('profile/view/{user_id}', [ProfileController::class, 'view_profile'])->name('profile.view');
Route::get('profile/edit/{user_id}', [ProfileController::class, 'edit_profile'])->name('profile.edit');
Route::put('profile/update/{user_id}', [ProfileController::class, 'update_profile'])->name('profile.update');
