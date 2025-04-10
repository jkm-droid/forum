<?php


use App\Http\Controllers\Admin\Member\Forum\BookMarkController;
use App\Http\Controllers\Member\NotificationController;
use App\Http\Controllers\Member\ProfileController;
use App\Http\Controllers\Member\SystemLogsController;
use Illuminate\Support\Facades\Route;


/**
 * registered users urls
 */
Route::name('member.')->group(function() {
    //user activity log
    Route::get('activity_log', [SystemLogsController::class, 'view_system_activities'])->name('activity.log');
});

/**
 * member profile
 * */
Route::name('profile.')->group(function (){
    Route::get('profile/view/{user_id}', [ProfileController::class, 'view_profile'])->name('view');
    Route::get('profile/edit/{user_id}', [ProfileController::class, 'show_profile_edit_form'])->name('show.edit');
    Route::put('profile/update/{user_id}', [ProfileController::class, 'update_profile_picture'])->name('update');
    Route::get('profile/settings/{user_id}', [ProfileController::class, 'profile_settings'])->name('settings');
    Route::put('profile/settings/update/{user_id}', [ProfileController::class, 'update_profile_settings'])->name('settings.update');
});

/**
 * user notifications
 */
Route::get('notifications/all', [NotificationController::class, 'show_all_notifications'])->name('notifications.view.all');
Route::post('notifications/mark_as_read/{notification_id}', [NotificationController::class, 'mark_as_read'])->name('notifications.mark.as.read');

/**
 * bookmarks
 */
Route::name('bookmark.')->group(function () {
    Route::post('bookmark/topic_message', [BookMarkController::class, 'bookmark_topic_message'])->name('save');
    Route::post('bookmark/status', [BookMarkController::class, 'get_bookmark_status'])->name('status');
    Route::get('bookmarks/{user_id}', [BookMarkController::class, 'get_user_bookmarks'])->name('all.bookmarks');
});
