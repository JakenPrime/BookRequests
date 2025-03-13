<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookRequestController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/user/{id}/orders', [OrderController::class, 'user'])->name('user.orders');
    Route::get('/user/{id}/request', [BookRequestController::class, 'user'])->name('user.request');
    Route::patch('/user/{id}/request', [BookRequestController::class, 'updateUser'])->name('user.update');

    Route::get('/books', [BookController::class, 'show'])->name('books');
    Route::post('/books', [BookController::class, 'store'])->name('books');
    Route::patch('/books/{id}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{id}', [BookController::class, 'delete'])->name('books.destroy');

    Route::get('/orders/{id?}', [OrderController::class, 'show'])->name('orders');
    Route::post('/orders/{id}', [OrderController::class, 'store'])->name('orders.store');
    Route::patch('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');

    Route::get('/requests/{id}', [BookRequestController::class, 'show'])->name('requests');
    Route::patch('/requests/{id}', [BookRequestController::class, 'update'])->name('requests.update');


    Route::get('/shelf-tag/{id}', [BookRequestController::class, 'shelfTag'])->name('shelf-tag');
});

require __DIR__.'/auth.php';
