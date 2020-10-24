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
    return view('management.ticket.addTicketG');
});

Route::get('Prueba1', function(){
    return view('management.ticket.addTicket');
});
Route::get('Dashboard', function(){
    return view('dashboard.index');
});

Route::get('/PruebaRegistroTicket','TicketController@create');








Route::middleware('auth')->group(function(){
    
    Route::get('/home','UserController@home')->name('home');
    
    
    //La siguiente línea nos ayuda a poner un prefijo que aparecerá en la url del navegador, para no escribirla varias veces
    
    //En este apartado irá todo lo que un administrador puede hacer
    Route::group([
        'middleware'=>'administrator',
        'prefix'=>'Administrador','as'=>'administrator.',
    ],function(){
        
            Route::get('Probar/{id}', 'UserController@probar')->name('prueba');
            //La página principal del administrador
            Route::get('','UserController@homeAdministrator')->name('home');
            
            //En esta parte va el CRUD de todo tipo de usuario, coordinador, técnico, usuario


            /*En la siguiente ruta mandamos llamar la función index, la que nos listará usuarios,
            pero se hará un filtro por departamento y role, para no cargar de información la plantilla
            */
            Route::get('/Usuarios/{idRole}/{idDepartment?}', 'UserController@index')->name('user.index');


            /*La siguiente función sirve para crear un Usuario, gracias a la función anterior,
            Ya sabemos de qué tipo será y si es necesario asignarle un departamento
            */
            Route::post('/Usuarios/Agregar','UserController@create')->name('user.create');

            /*La siguiente ruta nos sirve para mostrar no usuario, pasando como parametro su id,
            cuando la plantilla cargue, tendrá en ella adjuntada el objeto que se está deseando editar
            */
            
            Route::get('/Usuarios/Ver/{user}/Usuario', 'UserController@show')->name('user.show');


            /*La siguiente ruta es la que realmente se va a encargar de editar, después de modificados los datos
            se encarga de recolectarlos del formulario para enviar una consulta
            */
            Route::post('/Usuarios/EditarUsuario/{user}','UserController@update')->name('user.update');


            /*La siguiente ruta se va a encargar de eliminar pasando como parametro el id del usuario
            éste se va a obtener gracias a la ruta index, que nos proporciona los datos necesarios del
            usuario para su edición, eliminación o visualización
            */
            Route::post('/Usuarios/EliminarUsuario/{user}','UserController@destroy')->name('user.destroy');

            
            
            //La siguiente sección es para la gestión de departamentos
            Route::get('/Departamentos', 'DepartmentController@index')->name('department.index');
            Route::post('/Departamentos/Agregar','DepartmentController@create')->name('department.create');
            Route::get('/Departamentos/VerDepartamento/{department}', 'DepartmentController@show')->name('department.show');
            Route::post('/Departamentos/EditarDepartamento/{department}','DepartmentController@update')->name('department.update');
            Route::post('/Departamentos/EliminarDepartamento/{department}','DepartmentController@destroy')->name('department.destroy');


            //La siguiente sección es para la gestión de subáreas 
            Route::get('/SubAreas/{department}', 'SubareaController@index')->name('subarea.index');
            Route::post('/SubAreas/Agregar/{department}','SubareaController@create')->name('subarea.create');
            Route::get('/SubAreas/VerSubArea/{department}/{subarea}', 'SubareaController@show')->name('subarea.show');
            Route::post('/SubAreas/EditarSubArea/{department}/{subarea}','SubareaController@update')->name('subarea.update');
            Route::post('/SubAreas/EliminarSubArea/{department}/{subarea}','SubareaController@destroy')->name('subarea.destroy');



            //La siguiente sección es para la gestión de actividades
            Route::get('/Actividades/{subarea}', 'ActivityController@index')->name('activity.index');
            Route::post('/Actividades/Agregar/{subarea}','ActivityController@create')->name('activity.create');
            Route::get('/Actividades/VerActividad/{subarea}/{activity}', 'ActivityController@show')->name('activity.show');
            Route::post('/Actividades/EditarActividad/{subarea}/{activity}','ActivityController@update')->name('activity.update');
            Route::post('/Actividades/EliminarActividad/{subarea}/{activity}','ActivityController@destroy')->name('activity.destroy');


            //La siguiente es para gestión de tickets

            //Esta ruta nos redirige a los tickets en los que ha o está involucrado el usuario
            Route::get('/Tickets/MisTickets', 'TicketController@inbox')->name('ticket.inbox');

            //Esta ruta es ṕara la bandeja de entrada de todos los tickets
            Route::get('/Tickets/Bandeja', 'TicketController@inbox')->name('ticket.inbox');

            //Esta ruta es para la bandeja de entrada por departamento
            Route::get('/Tickets/Bandeja/{department?}', 'TicketController@inbox')->name('ticket.inbox');

            //Esta ruta es para los tickets no asignados, se hará el filtro por departamento
            Route::get('/Tickets/NoAsignados/{department}', 'TicketController@notAssigned')->name('ticket.notAssigned');
            
            //Esta ruta es para el historico de todos los departamentos
            Route::get('/Tickets/Histórico', 'TicketController@historical')->name('ticket.historical');
            

            //Esta ruta es para el historico por departamento
            Route::get('/Tickets/Histórico/{department?}', 'TicketController@historical')->name('ticket.historical');

            
            //Esta ruta nos muestra el formulario para agregar un ticket
            Route::get('/Tickets/Crear','TicketController@create')->name('ticket.create');


            //Esta ruta es para que nos muestre el formulario para agregar un ticket para alguien más
            Route::get('/Tickets/Crear/{guest?}','TicketController@create')->name('ticket.create');


            //Esta ruta es para agregar un ticket
            Route::post('/Tickets/Agregar','TicketController@storage')->name('ticket.storage');
            
            //Esta ruta es para agregar un ticket para alguien más
            Route::post('/Tickets/Agregar','TicketController@storage')->name('ticket.storage');

            //Esta ruta es para ver los detalles de un ticket en especifico
            Route::get('/Tickets/DetallesTicket/{ticket}', 'TicketController@show')->name('ticket.show');
            
            
            //Esta ruta es para redirigir a un formulario para editar un ticket en especifico
            Route::get('/Tickets/MostrarTicket/{ticket}', 'TicketController@edite')->name('ticket.edite');
            
            //Esta ruta edita y actualiza el ticket
            Route::post('/Tickets/EditarTicket/{ticket}','TicketController@update')->name('ticket.update');
            
            //Esta ruta como tal elimina el ticket
            Route::post('/Tickets/EliminarTicket/{ticket}','TicketController@destroy')->name('ticket.destroy');



            Route::get('Tickets/subareas','SubareaController@getSubareas');
            Route::get('Tickets/activities','ActivityController@getActivities');
        //}
       // abort(401,'No tienes autorización para entrar a esta sección');
    });







    Route::prefix('Coordinador')->name('coordinator.')->group(function()
    {
        
        Route::get('','UserController@homeCoordinator')->name('home');
        
        //En esta parte va la gestión de todo tipo de usuario, coordinador, técnico, usuario
        Route::get('/Usuarios/{idRole}/{idDepartment?}', 'UserController@index')->name('user.index');
        Route::post('/Usuarios/Agregar','UserController@create')->name('user.create');
        Route::get('/Usuarios/Ver/{user}/Usuario', 'UserController@show')->name('user.show');
        Route::post('/Usuarios/EditarUsuario/{user}','UserController@update')->name('user.update');
        Route::post('/Usuarios/EliminarUsuario/{user}','UserController@destroy')->name('user.destroy');



        //La siguiente sección es para la gestión de subáreas 

        Route::get('/SubAreas/{department}', 'SubareaController@index')->name('subarea.index');
        Route::post('/SubAreas/Agregar','SubAreaController@create')->name('subarea.create');
        Route::get('/SubAreas/VerSubArea/{subarea?}', 'SubareaController@show')->name('subarea.show');
        Route::post('/SubAreas/EditarSubArea/{subarea}','SubareaController@update')->name('subarea.update');
        Route::post('/SubAreas/EliminarSubArea/{subarea}','SubareaController@destroy')->name('subarea.destroy');

        //La siguiente sección es para la gestión de actividades
        Route::get('/Actividades/{subarea}', 'ActivityController@index')->name('activity.index');
        Route::post('/Actividades/Agregar','ActivityController@create')->name('activity.create');
        Route::get('/Actividades/VerActividad/{subarea}/{activity}', 'ActivityController@show')->name('activity.show');
        Route::post('/Actividades/EditarActividad/{subarea}/{activity}','ActivityController@update')->name('activity.update');
        Route::post('/Actividades/EliminarActividad/{subarea}/{activity}','ActivityController@destroy')->name('activity.destroy');


           //La siguiente es para gestión de tickets

           Route::get('/Tickets/Bandeja/{department}', 'TicketController@inbox')->name('ticket.inbox');
           Route::get('/Tickets/NoAsignados/{department}', 'TicketController@notAssigned')->name('ticket.notAssigned');
           Route::get('/Tickets/Histórico/{department}', 'TicketController@historical')->name('ticket.historical');
           Route::post('/Tickets/Crear','TicketController@create')->name('ticket.create');
           Route::post('/Tickets/Agregar','TicketController@storage')->name('ticket.storage');
           Route::get('/Tickets/DetallesTicket/{ticket}', 'TicketController@show')->name('ticket.show');
           Route::get('/Tickets/DetallesTicket/{ticket}', 'TicketController@edite')->name('ticket.edite');
           Route::post('/Tickets/EditarTicket/{ticket}','TicketController@update')->name('ticket.update');
           Route::post('/Tickets/EliminarTicket/{ticket}','TicketController@destroy')->name('ticket.destroy');
        //
    });
    
    Route::prefix('Asistente')->name('assistant.')->group(function()
    {
        
        Route::get('','UserController@homeAssistant')->name('home');
        
        //En esta parte va el CRUD de todo tipo de usuario, coordinador, técnico, usuario
        Route::get('/Usuarios/{role}', 'UserController@index')->name('user.index');
        Route::post('/Usuarios/Agregar','UserController@create')->name('user.create');
        Route::get('/Usuarios/VerUsuario/{user}', 'UserController@show')->name('uer.show');
        Route::post('/Usuarios/EditarUsuario/{user}','UserController@update')->name('user.update');
        Route::post('/Usuarios/EliminarUsuario/{user}','UserController@destroy')->name('user.destroy');


        //La siguiente es para gestión de tickets

        Route::get('/Tickets/{department}', 'TicketController@inbox')->name('ticket.inbox');
        Route::get('/Tickets/{department}', 'TicketController@historical')->name('ticket.historical');
        Route::get('/Tickets/NoAsignados/{department}', 'TicketController@notAssigned')->name('ticket.notAssigned');
        Route::post('/Tickets/Crear','TicketController@create')->name('ticket.create');
        Route::post('/Tickets/Agregar','TicketController@storage')->name('ticket.storage');
        Route::get('/Tickets/DetallesTicket/{ticket}', 'TicketController@show')->name('ticket.show');
        Route::get('/Tickets/DetallesTicket/{ticket}', 'TicketController@edite')->name('ticket.edite');
        Route::post('/Tickets/EditarTicket/{ticket}','TicketController@update')->name('ticket.update');
        Route::post('/Tickets/EliminarTicket/{ticket}','TicketController@destroy')->name('ticket.destroy');

        //
    });



    Route::prefix('Agente')->name('agent.')->group(function()
    {
        
        Route::get('','UserController@homeAgent')->name('home');
        //La siguiente es para gestión de tickets

        Route::get('/Tickets/{department}/{subarea}', 'TicketController@inbox')->name('ticket.inbox');
        Route::get('/Tickets/NoAsignados/{department}', 'TicketController@notAssigned')->name('ticket.notAssigned');
        Route::post('/Tickets/Crear','TicketController@create')->name('ticket.create');
        Route::post('/Tickets/Agregar','TicketController@storage')->name('ticket.storage');
        Route::get('/Tickets/DetallesTicket/{ticket}', 'TicketController@show')->name('ticket.show');
        Route::get('/Tickets/DetallesTicket/{ticket}', 'TicketController@edite')->name('ticket.edite');
        Route::post('/Tickets/EditarTicket/{ticket}','TicketController@update')->name('ticket.update');
        Route::post('/Tickets/EliminarTicket/{ticket}','TicketController@destroy')->name('ticket.destroy');
    });


    Route::prefix('Usuario')->name('user.')->group(function()
    {

    });
  

});
    

Auth::routes();





