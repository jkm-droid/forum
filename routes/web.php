<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminNotificationsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthenticatedSiteController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TopicController;
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
//topic view status
Route::post('/view/status', [AuthenticatedSiteController::class, 'get_topic_view_status'])->name('topic.status');


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


/**
 * admin authentication
 * */
Route::get('auth-admin/login', [AdminAuthController::class, 'admin_show_login'])->name('admin.show.login');
Route::post('auth-admin/login', [AdminAuthController::class, 'admin_login'])->name('admin.login');
Route::get('auth-admin/register', [AdminAuthController::class, 'admin_show_register'])->name('admin.show.register');
Route::post('auth-admin/register/save', [AdminAuthController::class, 'admin_register'])->name('admin.register');
Route::get('auth-admin/logout', [AdminAuthController::class, 'admin_logout'])->name('admin.logout');

/**
 * admin
 */

Route::get('dashboard', [DashboardController::class,'dashboard'])->name('dashboard');

/**
 * forums
 */
Route::get('forums',[ForumController::class, 'show_all_forums'])->name('show.all.forums');
Route::get('forums/create',[ForumController::class, 'show_forum_creation_form'])->name('show.forum.create');
Route::post('forums/save',[ForumController::class, 'forum_create'])->name('forum.create');
Route::get('forums/edit/{forum_id}',[ForumController::class, 'show_forum_edit_form'])->name('show.forum.edit');
Route::put('forums/update/{forum_id}',[ForumController::class, 'forum_edit'])->name('forum.edit');

Route::get('forums/drafted',[ForumController::class, 'show_drafted_forums'])->name('show.drafted.forums');
Route::get('forums/published',[ForumController::class, 'show_published_forums'])->name('show.published.forums');
Route::get('forum/delete/{forum_id}',[ForumController::class, 'delete_forum'])->name('forum.delete');
Route::get('forum/view/{forum_id}',[ForumController::class, 'view_forum'])->name('forum.view');
Route::get('forum/edit/{forum_id}',[ForumController::class, 'edit_forum'])->name('forum.edit');
Route::post('forum/publish_draft/{forum_id}',[ForumController::class, 'publish_draft_forum'])->name('forum.publish.draft');

/**
 * categories
 */

Route::get('categories',[CategoryController::class, 'show_all_categories'])->name('show.all.categories');
Route::get('categories/create',[CategoryController::class, 'show_category_creation_form'])->name('show.category.create');
Route::post('categories/save',[CategoryController::class, 'category_create'])->name('category.create');
Route::get('categories/edit/{category_id}',[CategoryController::class, 'show_category_edit_form'])->name('show.category.edit');
Route::put('categories/update/{category_id}',[CategoryController::class, 'category_edit'])->name('category.edit');

Route::get('categories/drafted',[CategoryController::class, 'show_drafted_categories'])->name('show.drafted.categories');
Route::get('categories/published',[CategoryController::class, 'show_published_categories'])->name('show.published.categories');
Route::get('category/delete/{category_id}',[CategoryController::class, 'delete_category'])->name('category.delete');
Route::get('category/view/{category_id}',[CategoryController::class, 'view_category'])->name('category.view');
Route::get('category/edit/{category_id}',[CategoryController::class, 'edit_category'])->name('category.edit');
Route::post('category/publish_draft/{category_id}',[CategoryController::class, 'publish_draft_category'])->name('category.publish.draft');

/**
 * topics
 */

Route::get('topics',[TopicController::class, 'show_all_topics'])->name('show.all.topics');
Route::get('topics/create',[TopicController::class, 'show_topic_creation_form'])->name('show.topic.create');
Route::post('topics/save',[TopicController::class, 'topic_create'])->name('topic.create');
Route::get('topics/edit/{topic_id}',[TopicController::class, 'show_topic_edit_form'])->name('show.topic.edit');
Route::put('topics/update/{topic_id}',[TopicController::class, 'topic_edit'])->name('topic.edit');

Route::get('topics/drafted',[TopicController::class, 'show_drafted_topics'])->name('show.drafted.topics');
Route::get('topics/published',[TopicController::class, 'show_published_topics'])->name('show.published.topics');
Route::get('topic/delete/{topic_id}',[TopicController::class, 'delete_topic'])->name('topic.delete');
Route::get('topic/view/{topic_id}',[TopicController::class, 'view_topic'])->name('topic.view');
Route::get('topic/edit/{topic_id}',[TopicController::class, 'edit_topic'])->name('topic.edit');
Route::post('topic/publish_draft/{topic_id}',[TopicController::class, 'publish_draft_topic'])->name('topic.publish.draft');

/**
 * users
 */
Route::get('users', [UserController::class, 'show_all_users'])->name('show.all.users');

/**
 * admin notifications
 */

Route::get('admin/notifications',[AdminNotificationsController::class, 'show_all_notifications'])->name('admin.notifications.show');
Route::post('admin/notifications/mark_as_read/{notification_id}', [AdminNotificationsController::class, 'mark_as_read'])->name('admin.notifications.mark.as.read');
