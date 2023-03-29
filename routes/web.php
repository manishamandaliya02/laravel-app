<?php

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

Route::get('/login', [App\Http\Controllers\LoginController::class, 'index'])->name('login');
Route::post('custom-login', [App\Http\Controllers\LoginController::class, 'authenticate'])->name('login.custom'); 

Route::group(['middleware' => 'auth:user'], function() {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/logout',  [App\Http\Controllers\LoginController::class, 'perform'])->name('logout.perform');
});

Route::resource('users', 'App\Http\Controllers\UserController');

Route::resource('posts',  'App\Http\Controllers\PostController');
Route::post('/share', [App\Http\Controllers\PostController::class, 'share'])->name('posts.share');
Route::get('/userlist', [App\Http\Controllers\PostController::class, 'userlist'])->name('posts.userlist');

