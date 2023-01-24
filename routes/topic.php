<?php

use App\Http\Controllers\Forum\TopicController;
use Illuminate\Support\Facades\Route;


/**
 * system topics
 */
Route::name('topic.')->group(function (){
    Route::get('/create/new_topic', [TopicController::class, 'show_create_new_topic_form'])->name('show.create.form');
    Route::post('/save/new_topic/', [TopicController::class, 'save_new_topic'])->name('save');

    Route::get('/edit/{slug}', [TopicController::class, 'show_edit_topic_form'])->name('show.edit.form');
    Route::post('/update/topic/{id}', [TopicController::class, 'update_topic'])->name('update');

    Route::post('/topic/delete', [TopicController::class, 'delete_topic'])->name('delete');
    //topic view status
    Route::post('/view/status', [TopicController::class, 'get_topic_view_status'])->name('status');
});
