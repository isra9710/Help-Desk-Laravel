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
    $user=Auth::user();
    
        Route::get('Administrador', 'HomeController@index')->name('home');
        Route::get('Administrador','UserController@home')->name('admin.user.home');
//Administración
    //Usuarios
    Route::get('Administración/Usuarios/{role}', 'UserController@index')->name('admin.user.index');
    Route::post('Administración/Usuarios/Agregar','UserController@create')->name('admin.user.create');
    Route::get('Administración/Usuarios/VerUsuario/{id}', 'UserController@show')->name('admin.user.show');
    Route::post('Administración/Usuarios/EditarUsuario/{id}','UserController@update')->name('admin.user.update');
    Route::get('Administración/Usuarios/EliminarUsuario/{id}','UserController@destroy')->name('admin.user.destroy');
    //Subáreas
    /*
    Route::get('Administración/Subárea', 'UserController@index')->name('admin.subarea.index');
    Route::post('Administración/Subárea/Agregar','UserController@create')->name('admin.subarea.create');
    Route::get('Administración/Usuarios/VerSubárea/{id}', 'UserController@show')->name('admin.subarea.show');
    Route::post('Administración/Usuarios/EditarSubárea/{id}','UserController@update')->name('admin.subarea.update');
    Route::get('Administración/Usuarios/EliminarSubárea/{id}','UserController@destroy')->name('admin.subarea.destroy');*/

});
    //roles

    //permisos

Auth::routes();





