<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordManagementController;
use App\Http\Controllers\Forum\SiteController;
use Illuminate\Support\Facades\Route;

/**
 * site urls
 */
Route::name('site.')->group(function(){
    /**
     * guest users
     */
    Route::get('/', [SiteController::class, 'showWelcomePage'])->name('home');
    Route::get('/category/{slug}', [SiteController::class, 'showSingleCategory'])->name('single.category');
    Route::get('/topic/{slug}', [SiteController::class, 'showTopic'])->name('single.topic');
    Route::get('/view/forum/list', [SiteController::class, 'showForumList'])->name('forum.list');
    Route::get('/view/top_topics', [SiteController::class, 'showTopTopics'])->name('top.topics');
    Route::get('read/message/{message_id}', [SiteController::class, 'getSingleMessage'])->name('single.message');
});

/**
 * user
 * */
Route::name('user.')->group(function(){
    /**
     * user authentication
     */
    Route::get('user/login', [AuthController::class, 'loginPage'])->name('show.login');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('user/register', [AuthController::class, 'registerPage'])->name('show.register');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    /**
     * password resetting
     */
    Route::get('user/forgot_pass', [PasswordManagementController::class, 'forgotPassForm'])->name('show.forgot_pass_form');
    Route::post('forgot_pass', [PasswordManagementController::class, 'submitForgotPassForm'])->name('forgot_submit');
    Route::get('user/reset_pass/{token}', [PasswordManagementController::class, 'resetPassForm'])->name('show.reset_form');
    Route::post('reset_pass', [PasswordManagementController::class, 'resetPass'])->name('reset_pass');

    /**
     * email verification
     */
    Route::get('account/verify/{token}', [AuthController::class, 'verifyEmail'])->name('verify.email');
});
