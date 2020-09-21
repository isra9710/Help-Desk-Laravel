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
    return view('welcome');
});


Route::get('Administrador','Admin\UsersController@home')->name('admin.user.home');

Route::get('Empleado',function(){
    return 'Página principal del empleado';
});


Route::get('Usuario',function(){
    return 'Página principal de usuario no registrado';
});


Route::get('Prueba', function(){
    return view('prueba.prueba');
});


//Gestión
    //tickets

    //asignación

//Configuración


//Reporte
    //creados

    //pendientes


//Administración
    //Empleado General
    Route::get('Administración/Usuarios/{tipo}', 'Admin\UsersController@index')->name('admin.user.index');
    Route::post('Administración/Usuarios/Agregar','Admin\UsersController@create')->name('admin.user.create');
    Route::get('Administración/Usuarios/VerUsuario/{id}', 'Admin\UsersController@show')->name('admin.user.show');
    Route::post('Administración/Usuarios/Editar/{id}','Admin\UsersController@update')->name('admin.user.update');
    Route::get('Administración/Usuarios/Eliminar/{id}','Admin\UsersController@destroy')->name('admin.user.destroy');
    //Tecnicos

    //roles

    //permisos

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

