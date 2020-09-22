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
//Vista principal de la aplicación
Route::get('/', function () {
    return view('auth.login');
});
//Route::get('home','HomeController')->name('home');
//Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');




Route::get('Empleado',function(){
    return 'Página principal del empleado';
});


Route::get('Usuario',function(){
    return 'Página principal de usuario no registrado';
});


Route::get('Prueba', function(){
    return view('prueba.prueba');
});


//Administrador
Route::middleware('auth')->group(function(){
    Route::get('Administrador','UsersController@home')->name('admin.user.home');
//Administración
    //Usuarios
    Route::get('Administración/Usuarios/{tipo}', 'UsersController@index')->name('admin.user.index');
    Route::post('Administración/Usuarios/Agregar','UsersController@create')->name('admin.user.create');
    Route::get('Administración/Usuarios/VerUsuario/{id}', 'UsersController@show')->name('admin.user.show');
    Route::post('Administración/Usuarios/EditarUsuario/{id}','UsersController@update')->name('admin.user.update');
    Route::get('Administración/Usuarios/EliminarUsuario/{id}','UsersController@destroy')->name('admin.user.destroy');
    //Subáreas
    Route::get('Administración/Subárea', 'UsersController@index')->name('admin.subarea.index');
    Route::post('Administración/Subárea/Agregar','UsersController@create')->name('admin.subarea.create');
    Route::get('Administración/Usuarios/VerSubárea/{id}', 'UsersController@show')->name('admin.subarea.show');
    Route::post('Administración/Usuarios/EditarSubárea/{id}','UsersController@update')->name('admin.subarea.update');
    Route::get('Administración/Usuarios/EliminarSubárea/{id}','UsersController@destroy')->name('admin.subarea.destroy');

});
    //roles

    //permisos

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

