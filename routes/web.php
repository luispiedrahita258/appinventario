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

Route::get('/', function () {
    return view('home');
});

Route::get('/profile',function(){
    return view('profile');
});

Route::get('/ver/{id}', 'App\\Http\\Controllers\\ProfileController@index');

Route::prefix('/admin')->namespace('App\\Http\\Controllers')-> group (function(){
Route::get('/', 'AdminController@index');
Route::get('/usuarios', 'UsersController@index');
Route::post('/usuarios/edit', 'UsersController@editarUsuario');
Route::get('/productos','ProductosController@index');
Route::post('/productos/all','ProductosController@all');
Route::get('/productos/imprimir','ProductosController@imprimir');



Route::resource('/usuarios','UsersController');
Route::resource('productos','ProductosController');

});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
