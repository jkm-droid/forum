<?php

use App\Http\Controllers\LikeController;
use App\Http\Controllers\MemberMessageController;
use Illuminate\Support\Facades\Route;


/**
 * messages/threads
 */

Route::name("message.")->group(function (){

    Route::post('/save/message/', [MemberMessageController::class, 'save_new_message'])->name('save');
    Route::post('/edit/message/', [MemberMessageController::class, 'edit_message'])->name('edit');
    //replies/comments
    Route::post('/post/reply/', [MemberMessageController::class, 'save_new_message_reply'])->name('save.reply');
    Route::post('/reply/delete', [MemberMessageController::class, 'delete_message_reply'])->name('reply.delete');

    /**
     * message likes
     */
    Route::post('message/like',[LikeController::class, 'like_message'])->name('like');

});
