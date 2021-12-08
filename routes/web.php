<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthenticatedSiteController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;
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
Route::get('/view/forum/list', [SiteController::class, 'show_forum_list'])->name('site.forum.list');
Route::get('/view/top_topics', [SiteController::class, 'show_top_topics'])->name('site.top.topics');

/**
 * authenticated users
 */
//messages/threads
Route::post('/save/message/', [AuthenticatedSiteController::class, 'save_new_message'])->name('site.save.message');
//replies/comments
Route::post('/post/reply/', [AuthenticatedSiteController::class, 'save_new_reply'])->name('site.save.reply');
Route::post('/reply/delete', [AuthenticatedSiteController::class, 'delete_reply'])->name('reply.delete');
//topics
Route::get('/create/new_topic', [AuthenticatedSiteController::class, 'show_create_new_topic_form'])->name('site.show.topic.form');
Route::post('/save/new_topic/', [AuthenticatedSiteController::class, 'save_new_topic'])->name('new.topic.save');
Route::get('/edit/{slug}', [AuthenticatedSiteController::class, 'show_edit_topic_form'])->name('show.edit.topic.form');
Route::post('/edit/topic/{id}', [AuthenticatedSiteController::class, 'edit_topic'])->name('edit.topic');
Route::post('/topic/delete', [AuthenticatedSiteController::class, 'delete_topic'])->name('topic.delete');



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
Route::get('profile/view/{username}', [ProfileController::class, 'view_profile'])->name('profile.view');
Route::get('profile/edit/{username}', [ProfileController::class, 'show_profile_edit_form'])->name('show.profile.edit');
Route::put('profile/update/{user_id}', [ProfileController::class, 'update_profile'])->name('profile.update');


/**
 * user notifications
 */
Route::get('notifications/all', [NotificationController::class, 'show_all_notifications'])->name('notifications.view.all');
Route::post('notifications/mark_as_read/{notification_id}', [NotificationController::class, 'mark_as_read'])->name('notifications.mark.as.read');

/**
 * message likes
 */

Route::post('message/like',[LikeController::class, 'like_message'])->name('message.like');
