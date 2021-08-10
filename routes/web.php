<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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
Auth::routes();


Route::get('/', function () {

    if (Auth::user()) { 
        return redirect('/dashboard');
    } 
    return view('welcome');
});

Route::get('/login',function(){
    return redirect('/');
})->name('login');

Route::get('/register',function(){
    return redirect('/');
});

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    $exitCode = Artisan::call('storage:link', [] );
    echo $exitCode;
});

Route::get('/migration', function () {
    Artisan::call('migrate');
    $exitCode = Artisan::call('migrate', [] );
    echo $exitCode;
});

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])
->name('dashboard');

Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');

Route::post('/profile', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('profile');

Route::post('/password', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('password');

Route::resource('property-types', App\Http\Controllers\ProprtyTypeController::class);

Route::resource('properties', App\Http\Controllers\PropertyController::class);

Route::resource('roles', App\Http\Controllers\RoleController::class)->middleware('can:add_users');

Route::resource('users', App\Http\Controllers\UserController::class)->middleware('can:add_users');

Route::resource('document-types', App\Http\Controllers\DocumentTypeController::class);

Route::get('properties/{id}/documents',[App\Http\Controllers\DocumentController::class,'create'])
->name('properties.documents');

Route::post('properties/{id}/documents',[App\Http\Controllers\DocumentController::class,'store'])
->name('properties.documents');

