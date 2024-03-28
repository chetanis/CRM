<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommandController;
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

//delete a client
Route::delete('/clients/{client}', [ClientController::class, 'destroy']);

//--------   Products routes  --------//

//show the create prudoct form
Route::get('/add-product', [ProductController::class,'create'])->name('products.create');

//create a product
Route::post('/add-product', [ProductController::class,'store'])->name('products.store');

//all products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

//show product
Route::get('/products/{product}', [ProductController::class, 'show']);

//update a product
Route::put('/products/{product}', [ProductController::class, 'update']);

//add stock to a product
Route::post('/products/{product}/add-stock', [ProductController::class, 'addStock'])->name('manage-stock');

//search for a product
Route::get('/search-product', [ProductController::class, 'search'])->name('search-product');

//delete a product
Route::delete('/products/{product}', [ProductController::class, 'destroy']);

//--------   Products commands  --------//
//show the create command form
Route::get('/add-command', [CommandController::class,'create'])->name('commands.create');

//create a command
Route::post('/add-command', [CommandController::class,'store'])->name('commands.store');

//all commands
Route::get('/commands', [CommandController::class, 'index'])->name('commands.index');

//show command
Route::get('/commands/{command}', [CommandController::class, 'show']);

//confirm the command
Route::put('/commands/{command}/confirm', [CommandController::class, 'confirm'])->name('commands.confirm');

//cancel the command
Route::put('/commands/{command}/cancel', [CommandController::class, 'cancel'])->name('commands.cancel');

//show invoice
Route::get('/sales/{sale}/', [CommandController::class, 'viewInvoice']);

//download invoice
Route::get('/sales/{sale}/facture', [CommandController::class, 'downloadInvoice']);

//------- other routes ----------//
// show home page
Route::get('/dashboard',function () {
    return view('index');
})->name('dashboard')->middleware('auth');


// Catch-all route to redirect to the home page
Route::get('/{any}', function () {
    return redirect('/dashboard');
})->where('any', '.*');

