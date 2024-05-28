<?php

use App\Models\Appointment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\NotificationController;

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


//-------------- auth routes --------------//
//show the login form 
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');

//login the user
Route::post('/login', [UserController::class, 'login']);

//logout a user 
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

//-------------- admin routes --------------//

Route::middleware(['auth', 'admin'])->group(function () {
    //--------- user managment ------------//
    // show the register form
    Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
    //create a user 
    Route::post('/register', [UserController::class, 'register'])->name('create-user');
    //all users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    //search for a user
    Route::get('/search-user', [UserController::class, 'search'])->name('search-user');

    //show user
    Route::get('/users/{user}', [UserController::class, 'show']);

    //update a user
    Route::put('/users/{user}', [UserController::class, 'update']);

    //show Logs
    Route::get('/logs', [LogController::class, 'index'])->name('logs');

    //change the user assigned to a client
    Route::put('/clients/{client}/change-user', [ClientController::class, 'changeUser'])->name('change-user');

    //show the users report
    Route::get('/reports/users', [ReportController::class, 'usersReport'])->name('users-report');

    //generate the users report
    Route::post('/reports/users', [ReportController::class, 'generateUsersReport'])->name('generate-users-report');
});

//-------------- superuser and admin routes --------------//

Route::middleware(['auth', 'superuserOrAdmin'])->group(function () {
    //--------- Products managment ------------//

    //show the create prudoct form
    Route::get('/add-product', [ProductController::class, 'create'])->name('products.create');

    //create a product
    Route::post('/add-product', [ProductController::class, 'store'])->name('products.store');

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
});

//--------   User routes  --------//

Route::middleware(['auth'])->group(function () {
    //--------   Client managment  --------//
    //show the create form 
    Route::get('/add-client', [ClientController::class, 'create'])->name('clients.create');

    //create a client
    Route::post('/add-client', [ClientController::class, 'store'])->name('clients.store');

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


    //--------   commands managment  --------//
    //show the create command form
    Route::get('/add-command', [CommandController::class, 'create'])->name('commands.create');

    //create a command
    Route::post('/add-command', [CommandController::class, 'store'])->name('commands.store');

    //all commands
    Route::get('/commands', [CommandController::class, 'index'])->name('commands.index');

    //show command
    Route::get('/commands/{command}', [CommandController::class, 'show']);

    //confirm the command
    Route::put('/commands/{command}/confirm', [CommandController::class, 'confirm'])->name('commands.confirm');

    //cancel the command
    Route::put('/commands/{command}/cancel', [CommandController::class, 'cancel'])->name('commands.cancel');

    //delete a command
    Route::delete('/commands/{command}', [CommandController::class, 'destroy']);

    //show invoice
    Route::get('/sales/{sale}/', [CommandController::class, 'viewInvoice']);

    //download invoice
    Route::get('/sales/{sale}/facture', [CommandController::class, 'downloadInvoice']);


    // ------------ appointment managment --------------//
    //show the create appointment form
    Route::get('/add-appointment', [AppointmentController::class, 'create'])->name('appointments.create');

    //create a new appointment 
    Route::post('/add-appointment', [AppointmentController::class, 'store']);

    // all appointments
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');

    //show appointment
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show']);

    //reschedule appointment
    Route::put('/appointments/{appointment}/reschedule', [AppointmentController::class, 'reschedule'])->name('appointments.reschedule');

    //cancel appointment
    Route::put('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

    //confirm appointment  
    Route::put('/appointments/{appointment}/confirm', [AppointmentController::class, 'confirm'])->name('appointments.confirm');

    //delete appointment
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy']);   
    

    //--------  Notifications  --------//
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);
    
    //--------  Reports  --------//
    //show the client report
    Route::get('/reports/clients', [ReportController::class, 'clientsReport'])->name('clients-report');

    //generate the client report
    Route::post('/reports/clients', [ReportController::class, 'generateClientsReport'])->name('generate-clients-report');

    //show the command report
    Route::get('/reports/commands', [ReportController::class, 'commandsReport'])->name('commands-report');

    //generate the command report
    Route::post('/reports/commands', [ReportController::class, 'generateCommandsReport'])->name('generate-commands-report');
    
    //------- other routes ----------//

    // show home page
    Route::get('/dashboard', [Controller::class, 'dashboard'])->name('dashboard');

    //filter sales data in the dashboard
    Route::get('/sales-filter', [Controller::class, 'filterSales']);

    //filter revenue data in the dashboard
    Route::get('/revenue-filter', [Controller::class, 'filterRevenue']);

    //filter client data in the dashboard
    Route::get('/clients-filter', [Controller::class, 'filterClients']);

});


// Catch-all route to redirect to the home page
Route::get('/{any}', function () {
    return redirect('/dashboard');
})->where('any', '.*');
