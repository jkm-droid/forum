<?php

use App\Http\Controllers\LikeController;
use App\Http\Controllers\MemberMessageController;
use Illuminate\Support\Facades\Route;


/**
 * messages/threads
 */

Route::name("message.")->group(function (){
    //messages to a given topic/thread
    Route::post('/save/message/', [MemberMessageController::class, 'save_message'])->name('save');
    Route::get('/edit/message/{message_id}', [MemberMessageController::class, 'show_message_edit_form'])->name('show.edit.form');
    Route::put('/update/message/{message_id}', [MemberMessageController::class, 'update_message'])->name('update');
    Route::post('/ajax/delete/message', [MemberMessageController::class, 'ajax_delete_message'])->name('delete');
    Route::delete('/post/delete/{message_id}', [MemberMessageController::class, 'post_delete_message'])->name('delete');

    //replies/comments to a given message
    Route::post('/message/save/reply', [MemberMessageController::class, 'save_message_reply'])->name('save.reply');
    Route::get('/message/edit/reply/{reply_id}', [MemberMessageController::class, 'show_message_reply_form'])->name('show.edit.reply.form');
    Route::put('/message/update/reply/{reply_id}', [MemberMessageController::class, 'update_message_reply'])->name('update.reply');
    Route::post('/message/delete/reply/', [MemberMessageController::class, 'delete_message_reply'])->name('delete.reply');

    //message likes
    Route::post('message/like',[LikeController::class, 'like_message'])->name('like');

});
