<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();


Route::middleware(['auth'])->group(function (){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'city'],function(){
        Route::get('/list', [App\Http\Controllers\CityController::class, 'index'])->name('city.index');
        Route::get('/ajax', [CityController::class, 'ajax'])->name('city.ajax');
        Route::get('new', [CityController::class, 'new'])->name('city.new');
        Route::get('show', [CityController::class, 'show'])->name('city.show');
        Route::post('create', [CityController::class, 'create'])->name('city.create');
        Route::post('update', [CityController::class, 'update'])->name('city.update');
        Route::post('delete', [CityController::class, 'delete'])->name('city.delete');
    } );

    Route::group(['prefix' => 'client'],function(){
        Route::get('/list', [App\Http\Controllers\ClientController::class, 'index'])->name('client.index');
        Route::get('/ajax', [ClientController::class, 'ajax'])->name('client.ajax');
        Route::get('new', [ClientController::class, 'new'])->name('client.new');
        Route::get('show', [ClientController::class, 'show'])->name('client.show');
        Route::post('create', [ClientController::class, 'create'])->name('client.create');
        Route::post('update', [ClientController::class, 'update'])->name('client.update');
        Route::post('delete', [ClientController::class, 'delete'])->name('client.delete');
        Route::post('importador', [ClientController::class, 'importador'])->name('client.importador');
        Route::post('exportador', [ClientController::class, 'exportador'])->name('client.exportador');

    });

    Route::group(['prefix' => 'user'],function(){
        Route::get('/list', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
        Route::get('/ajax', [UserController::class, 'ajax'])->name('user.ajax');
        Route::get('new', [UserController::class, 'new'])->name('user.new');
        Route::get('show', [UserController::class, 'show'])->name('user.show');
        Route::post('create', [UserController::class, 'create'])->name('user.create');
        Route::post('update', [UserController::class, 'update'])->name('user.update');
        Route::post('delete', [UserController::class, 'delete'])->name('user.delete');
    });

});




