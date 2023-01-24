<?php


use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminNotificationsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Forum\TopicController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
