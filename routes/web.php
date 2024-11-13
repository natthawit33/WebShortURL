<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\URLController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home.index');
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/registers', [AuthController::class, 'register'])->name('registers');

Route::get('/index', function () {
    return view('home.index');
})->name('index');

Route::post('/shorten', [URLController::class, 'create'])->name('url.shortURL');

Route::get('/mylist', [URLController::class, 'Myurl'])->name('mylist');
Route::put('/urls/{id}', [UrlController::class, 'updateUrl'])->name('urls.update');


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::delete('/urls/{id}', [UrlController::class, 'deleteUrl'])->name('urls.destroy');
Route::get('/{shortUrl}', [UrlController::class, 'redirectUrl'])->name('url.redirect');
