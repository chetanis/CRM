<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;

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


//--------   User routes  --------//
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


//--------   Client routes  --------//
//show the create form 
Route::get('/add-client', [ClientController::class,'create'])->name('clients.create');

//create a client
Route::post('/add-client', [ClientController::class,'store'])->name('clients.store');

//all clients
Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');

//show client
Route::get('/clients/{client}', [ClientController::class, 'show']);

//update a client
Route::put('/clients/{client}', [ClientController::class, 'update']);

//search for a client
Route::get('/search-client', [ClientController::class, 'search'])->name('search-client');

//--------   Products routes  --------//
//show the create prudoct form
Route::get('/add-product', [ProductController::class,'create'])->name('products.create');

//create a product
Route::post('/add-product', [ProductController::class,'store'])->name('products.store');

//------- other routes ----------//
// show home page
Route::get('/dashboard',function () {
    return view('index');
})->name('dashboard')->middleware('auth');


// Catch-all route to redirect to the home page
Route::get('/{any}', function () {
    return redirect('/dashboard');
})->where('any', '.*');

