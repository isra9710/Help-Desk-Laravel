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





Route::get('Empleado',function(){
    return 'Página principal del empleado';
});


Route::get('Usuario',function(){
    return 'Página principal de usuario no registrado';
});


Route::get('Prueba', function(){
    return view('prueba.prueba');
});



Route::middleware('auth')->group(function(){
    
    Route::get('/home','UserController@home')->name('home');
    
    
    //La siguiente línea nos ayuda a poner un prefijo que aparecerá en la url del navegador, para no escribirla varias veces
    
    //En este apartado irá todo lo que un administrador puede hacer
    Route::prefix('Administrador')->name('administrator.')->group(function()
    {
        //La página principal del administrador
        Route::get('','UserController@homeAdministrator')->name('home');
        
        //En esta parte va el CRUD de todo tipo de usuario, coordinador, técnico, usuario


        /*En la siguiente ruta mandamos llamar la función index, la que nos listará usuarios,
         pero se hará un filtro por departamento y role, para no cargar de información la plantilla
        */
        Route::get('/Usuarios/{role}/{department}', 'UserController@index')->name('user.index');


        /*La siguiente función sirve para crear un Usuario, gracias a la función anterior,
          Ya sabemos de qué tipo será y si es necesario asignarle un departamento
        */
        Route::post('/Usuarios/Agregar','UserController@create')->name('user.create');

        /*La siguiente ruta nos sirve para mostrar no usuario, pasando como parametro su id,
          cuando la plantilla cargue, tendrá en ella adjuntada el objeto que se está deseando editar
        */
        Route::get('/Usuarios/VerUsuario/{id}', 'UserController@show')->name('user.show');


        /*La siguiente ruta es la que realmente se va a encargar de editar, después de modificados los datos
          se encarga de recolectarlos del formulario para enviar una consulta
        */
        Route::post('/Usuarios/EditarUsuario/{id}','UserController@update')->name('user.update');


        /*La siguiente ruta se va a encargar de eliminar pasando como parametro el id del usuario
         éste se va a obtener gracias a la ruta index, que nos proporciona los datos necesarios del
         usuario para su edición, eliminación o visualización
        */
        Route::get('/Usuarios/EliminarUsuario/{id}','UserController@destroy')->name('user.destroy');


        
    });



    Route::prefix('Coordinador')->name('coordinator.')->group(function()
    {
        
        Route::get('','UserController@homeCoordinator')->name('home');
        
        //En esta parte va el CRUD de todo tipo de usuario, coordinador, técnico, usuario
        Route::get('/Usuarios/{role}', 'UserController@index')->name('user.index');
        Route::post('/Usuarios/Agregar','UserController@create')->name('user.create');
        Route::get('/Usuarios/VerUsuario/{id}', 'UserController@show')->name('user.show');
        Route::post('/Usuarios/EditarUsuario/{id}','UserController@update')->name('user.update');
        Route::get('/Usuarios/EliminarUsuario/{id}','UserController@destroy')->name('user.destroy');


        //
    });
    

  

});
    

Auth::routes();





