<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

//show the login form 
Route::get('/login', [UserController::class,'showLoginForm'])->name('login');

//login the user
Route::post('/login', [UserController::class,'login']);

// show the register form
Route::get('/register', [UserController::class,'showRegisterForm'])->name('register');

//create a user 
Route::post('/register', [UserController::class,'register']);

//logout a user 
Route::post('/logout', [UserController::class,'logout'])->name('logout');

// show home page
Route::get('/dashboard',function () {
    return view('index');
})->name('dashboard')->middleware('auth');
Route::get('/',function () {
    return view('index');
})->name('dashboard')->middleware('auth');


