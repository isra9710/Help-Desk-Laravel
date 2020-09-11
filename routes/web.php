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


Route::get('Administrador',function(){
    return view('layouts.test');
});


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
    Route::get('Administración/Usuarios', 'Admin\UsersController@indexE')->name('admin.user.indexE');
    Route::post('Administración/Usuarios/Agregar','Admin\UsersController@createE')->name('admin.user.createE');
    Route::get('Administración/Usuarios/VerUsuario/{id}', 'Admin\UsersController@showE')->name('admin.user.showE');
    Route::post('Administración/Usuarios/Editar/{id}','Admin\UsersController@updateE')->name('admin.user.updateE');
    Route::get('Administración/Usuarios/Eliminar/{id}','Admin\UsersController@destroyE')->name('admin.user.destroyE');
    //Tecnicos

    //roles

    //permisos
