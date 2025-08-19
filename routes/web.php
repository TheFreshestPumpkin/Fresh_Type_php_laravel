<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\DialogsController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;

Route::view('/','welcome');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/post/{post}/comments', [CommentsController::class, 'store'])->name('comments.store');

Route::delete('post/{post}/comments/{comment}', [CommentsController::class,'destroy'])->name('comments.destroy');

Route::resource('/post', PostsController::class);

Route::middleware(['auth'])->group(function () {

    Route::get('/dialogs', [DialogsController::class, 'index'])->name('dialogs.index');
    Route::get('/dialogs/unread-count', [DialogsController::class, 'fetchUnreadCount'])
        ->name('dialogs.unread');
    Route::get('/dialogs/create', [DialogsController::class, 'create'])->name('dialogs.create');
    Route::get('/dialogs/{dialog}', [DialogsController::class, 'show'])->name('dialogs.show');
    Route::post('/dialogs/store', [DialogsController::class, 'store'])->name('dialogs.store');
    Route::get('/dialogs/{dialog}/messages', [MessagesController::class, 'fetchDialogMessages'])
        ->name('messages.fetch');
    Route::post('/dialogs/{dialog}/messages', [MessagesController::class, 'store'])
        ->name('messages.store');

    Route::get('/friends', [FriendsController::class, 'index'])->name('friends.index');
    Route::get('/friends/requests', [FriendsController::class, 'requests'])->name('friends.requests');
    Route::post('/friends/add/{id}', [FriendsController::class, 'add'])->name('friends.add');
    Route::post('/friends/accept/{id}', [FriendsController::class, 'accept'])->name('friends.accept');
    Route::delete('/friends/remove/{id}', [FriendsController::class, 'remove'])->name('friends.remove');
    Route::get('/friends/search', [FriendsController::class, 'search'])->name('friends.search');

    Route::get('/user/{user}', [UsersController::class, 'show'])->name('profile');
});
