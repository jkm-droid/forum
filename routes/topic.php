<?php


use App\Http\Controllers\Auth\MemberTopicController;
use Illuminate\Support\Facades\Route;


/**
 * system topics
 */
Route::name('topic.')->group(function (){
    Route::get('/create/new_topic', [MemberTopicController::class, 'show_create_new_topic_form'])->name('show.create.form');
    Route::post('/save/new_topic/', [MemberTopicController::class, 'save_new_topic'])->name('save');

    Route::get('/edit/{slug}', [MemberTopicController::class, 'show_edit_topic_form'])->name('show.edit.form');
    Route::post('/update/topic/{id}', [MemberTopicController::class, 'update_topic'])->name('update');

    Route::post('/topic/delete', [MemberTopicController::class, 'delete_topic'])->name('delete');
    //topic view status
    Route::post('/view/status', [MemberTopicController::class, 'get_topic_view_status'])->name('status');
});
