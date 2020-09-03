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
    return view('layouts.app');
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