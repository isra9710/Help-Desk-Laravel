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







//Route::get('Reportes','ChartController@indexTechnician')->name('chart.index.technician');







Route::middleware('auth')->group(function(){
    
    Route::get('/home','UserController@home')->name('home');
    
    
    //La siguiente línea nos ayuda a poner un prefijo que aparecerá en la url del navegador, para no escribirla varias veces
    
    //En este apartado irá todo lo que un administrador puede hacer
    Route::group([
        'middleware'=>'administrator',
        'prefix'=>'Administrador','as'=>'administrator.',
    ],function(){
        
        
            //La página principal del administrador
            Route::get('','UserController@homeAdministrator')->name('home');
            //Ruta para mostrar el formulario de cambio de contraseña
            Route::get('/CambiarContraseña','UserController@changePassForm')->name('change.pass');
            //Ruta para actualizar contraseña
            Route::post('/ActualizarContraseña','UserController@updatePass')->name('update.pass');

            //Respaldo de base de datos
            Route::get('/RespaldoBase','BackupController@create')->name('create.backup');

            //Gestión de preguntas
            Route::get('/Preguntas','QuestionController@create')->name('question.create');
            Route::post('/AgregarPregunta','QuestionController@store')->name('question.store');
            Route::get('/Editar/{question}/Pregunta','QuestionController@edit')->name('question.edit');
            Route::post('/ActualizarPregunta/{question}','QuestionController@update')->name('question.update');
            Route::post('/EliminarPregunta/{question}','QuestionController@destroy')->name('question.destroy');


            //Reportes
            Route::get('/ReportesTecnico/{department}','ChartController@indexTechnician')->name('chart.index.technician');

            Route::post('/TicketsTecnico','ChartController@ticketAgent')->name('chart.ticket.technician');


            Route::get('/ReportesSubarea/{department}','ChartController@indexSubarea')->name('chart.index.subarea');

            Route::post('/TicketsSubarea','ChartController@ticketSubarea')->name('chart.ticket.subarea');



            Route::get('/ReportesDepartamento/{department}','ChartController@indexDepartment')->name('chart.index.department');

            Route::post('/TicketsDepartamento','ChartController@ticketSubarea')->name('chart.ticket.department');

           


            //En esta parte va el CRUD de todo tipo de usuario, coordinador, técnico, usuario


            /*En la siguiente ruta mandamos llamar la función index, la que nos listará usuarios,
            pero se hará un filtro por departamento y role, para no cargar de información la plantilla
            */
            Route::get('/Usuarios/{idRole}/{idDepartment?}', 'UserController@index')->name('user.index');


            /*La siguiente función sirve para crear un Usuario, gracias a la función anterior,
            Ya sabemos de qué tipo será y si es necesario asignarle un departamento
            */
            Route::post('/Usuarios/Agregar','UserController@store')->name('user.store');

            /*La siguiente ruta nos sirve para mostrar no usuario, pasando como parametro su id,
            cuando la plantilla cargue, tendrá en ella adjuntada el objeto que se está deseando editar
            */
            
            Route::get('/Usuarios/Ver/{user}/Usuario', 'UserController@edit')->name('user.edit');


            /*
                La siguiente ruta es para ver detalles de un usuario en especifico
            */
            Route::get('/Usuarios/Detalles/{user}/Usuario', 'UserController@show')->name('user.details');

            /*La siguiente ruta es la que realmente se va a encargar de editar, después de modificados los datos
            se encarga de recolectarlos del formulario para enviar una consulta
            */
            Route::post('/Usuarios/EditarUsuario/{user}','UserController@update')->name('user.update');


            /*La siguiente ruta se va a encargar de eliminar pasando como parametro el id del usuario
            éste se va a obtener gracias a la ruta index, que nos proporciona los datos necesarios del
            usuario para su edición, eliminación o visualización
            */
            Route::post('/Usuarios/ActivarDesactivar/{user}','UserController@destroy')->name('user.destroy');
            

            Route::post('/Usuarios/ActividadesUsuario/{user}', 'AssignmentController@index')->name('assignments.users');
            
            //La siguiente sección es para la gestión de departamentos
            Route::get('/Departamentos', 'DepartmentController@index')->name('department.index');
            Route::post('/Departamentos/Agregar','DepartmentController@store')->name('department.store');
            Route::get('/Departamentos/VerDepartamento/{department}', 'DepartmentController@edit')->name('department.edit');
            Route::post('/Departamentos/EditarDepartamento/{department}','DepartmentController@update')->name('department.update');
            Route::post('/Departamentos/ActivarDesactivar/{department}','DepartmentController@destroy')->name('department.destroy');


            //La siguiente sección es para la gestión de subáreas 
            Route::get('/SubAreas/{department}', 'SubareaController@index')->name('subarea.index');
            Route::post('/SubAreas/Agregar/{department}','SubareaController@store')->name('subarea.store');
            Route::get('/SubAreas/VerSubArea/{department}/{subarea}', 'SubareaController@edit')->name('subarea.edit');
            Route::post('/SubAreas/EditarSubArea/{department}/{subarea}','SubareaController@update')->name('subarea.update');
            Route::post('/SubAreas/ActivarDesactivar/{department}/{subarea}','SubareaController@destroy')->name('subarea.destroy');



            //La siguiente sección es para la gestión de actividades
            Route::get('/Actividades/{subarea}', 'ActivityController@index')->name('activity.index');
            Route::post('/Actividades/Agregar/{subarea}','ActivityController@store')->name('activity.store');
            Route::get('/Actividades/VerActividad/{subarea}/{activity}', 'ActivityController@edit')->name('activity.edit');
            Route::post('/Actividades/EditarActividad/{subarea}/{activity}','ActivityController@update')->name('activity.update');
            Route::post('/Actividades/ActivarDesactivar/{subarea}/{activity}','ActivityController@destroy')->name('activity.destroy');
            //Route::post('Actividades/ActividadesUsuario/{activity}', 'AssignmentController@index')->name('assignments.activities');


            //La siguiente ruta es para hacer gestión de las actividades asignadas a usuarios y de los usuarios asignados a actividades
            Route::get('/AsignaciónActividadesUsuario/{user}','AssignmentController@index')->name('assignment.user');
            Route::get('/AsignaciónUsuarios/{activity}','AssignmentController@index')->name('assignment.activity');
            //Route::post('/Asignación/{user?}/{activity?}','AssignmentController@store')->name('assignment.store');
            //Asignación de una actividad a un usuario
            Route::post('/AsignaciónActividad/{user}','AssignmentController@storeActivity')->name('assignment.store.activity');
            //Asignación de un usuario a una actividad
            Route::post('/AsignaciónUsuario/{activity}','AssignmentController@storeAgent')->name('assignment.store.agent');
            Route::post('/Eliminación/{assignment}/{user?}/{activity?}','AssignmentController@destroy')->name('assignment.destroy');
            Route::get('/AsignaciónTemporal/{user}/{option}','AssignmentController@temporary')->name('user.status');
            Route::post('/AsignaciónTemporalActividad/{agent}/{option}','AssignmentController@temporaryAssignment')->name('assignment.temporary.activity');
            Route::post('/Asignasdasdsdasral/{agent}/{option}','AssignmentController@temporaryAssignmentAll')->name('assignment.temporary.all');


            //La siguiente es para gestión de tickets

            /*Esta ruta nos redirige a los tickets en los que ha o está involucrado el usuario
            Route::get('/Tickets/MisTickets', 'TicketController@inbox')->name('ticket.inbox');*/

            //Esta ruta es ṕara la bandeja de entrada de todos los tickets
            //Route::get('/Tickets/Bandeja', 'TicketController@inbox')->name('ticket.inbox');

            //Esta ruta es para la bandeja de entrada por departamento
            Route::get('/Tickets/Bandeja/{department?}', 'TicketController@inbox')->name('ticket.inbox');
            
            //Esta ruta es para el historico de todos los departamentos
            Route::get('/Tickets/Histórico', 'TicketController@historical')->name('ticket.historical');
            
            //Esta ruta es para los tickets no asignados, se hará el filtro por departamento
            Route::get('/Tickets/NoAsignados/{department}', 'TicketController@notAssigned')->name('ticket.notAssigned');            

            //Esta ruta es para el historico por departamento
            Route::get('/Tickets/Histórico/{department?}', 'TicketController@historical')->name('ticket.historical');

            
            //Esta ruta nos muestra el formulario para agregar un ticket
            Route::get('/Tickets/Crear','TicketController@create')->name('ticket.create');


            //Esta ruta es para que nos muestre el formulario para agregar un ticket para alguien más
            Route::get('/Tickets/Crear/{guest?}','TicketController@create')->name('ticket.create');


            //Esta ruta es para agregar un ticket
            Route::post('/Tickets/Agregar','TicketController@store')->name('ticket.store');
            
           

            //Esta ruta es para ver los detalles de un ticket en especifico
            Route::get('/Tickets/DetallesTicket/{ticket}/{option}', 'TicketController@show')->name('ticket.show');
            
            
            //Esta ruta es para redirigir a un formulario para editar un ticket en especifico
            Route::get('/Tickets/MostrarTicket/{ticket}/{option}', 'TicketController@edit')->name('ticket.edit');
            
            //Esta ruta edita y actualiza el ticket
            Route::post('/Tickets/EditarTicket/{ticket}/{option}','TicketController@update')->name('ticket.update');
            
            //Esta ruta como tal elimina el ticket
            Route::post('/Tickets/EliminarTicket/{ticket}/{ticketOption}/{option}','TicketController@destroy')->name('ticket.destroy');

            Route::get('/MisTickets/{employeeNumber}','TicketController@myTickets')->name('ticket.mytickets');

            Route::get('/Transferir/{ticket}/{option}','TicketController@toTransfer')->name('ticket.transfer');
            Route::post('/Reasignar/{ticket}/{option}','TicketController@reasign')->name('ticket.reasign');
            
            
            Route::get('Tickets/subareas','SubareaController@getSubareas');
            Route::get('Tickets/activities','ActivityController@getActivities');


            //Muestra formulario para añadir un archivo
            Route::get('/Archivo/Crear/{ticket}/{option}','FileController@create')->name('file.create');
            //Muestra formulario para añadir archivo a tu ticket
           // Route::get('/Archivo/CrearMiArchivo/{ticket}/{option}','FileController@create')->name('myfile.create');
            //Se crea la asignación del archivo al ticket
            Route::post('/Archivo/{ticket}/{option}','FileController@store')->name('file.store');

            Route::get('/DescargarArchivo/{file}','FileController@download')->name('file.download');

            Route::get('/Mensaje/Crear/{ticket}/{option}','MessageController@create')->name('message.create');
            Route::post('/Mensajes/{ticket}/{option}','MessageController@store')->name('message.store');

            //Encuesta
            Route::post('/Evaluar/{ticket}','PollController@store')->name('poll.store');



            //Reportes
           // Route::get('/Reportes','')->name('index.chart');
            
    });







    Route::prefix('Coordinador')->name('coordinator.')->group(function()
    {
        
        Route::get('','UserController@homeCoordinator')->name('home');
        
           //Ruta para mostrar el formulario de cambio de contraseña
        Route::get('/CambiarContraseña','UserController@changePassForm')->name('change.pass');
           //Ruta para actualizar contraseña
        Route::post('/ActualizarContraseña','UserController@updatePass')->name('update.pass');


          //Reportes
          Route::get('/ReportesTecnico/{department}','ChartController@indexTechnician')->name('chart.index.technician');

          Route::post('/TicketsTecnico','TicketController@ticketAgent')->name('chart.ticket.technician');



        //En esta parte va la gestión de todo tipo de usuario, coordinador, técnico, usuario
        Route::get('/Usuarios/{idRole}/{idDepartment?}', 'UserController@index')->name('user.index');
        Route::post('/Usuarios/Agregar','UserController@store')->name('user.store');
        /*La siguiente ruta nos sirve para mostrar no usuario, pasando como parametro su id,
            cuando la plantilla cargue, tendrá en ella adjuntada el objeto que se está deseando editar
            */
            
        Route::get('/Usuarios/Ver/{user}/Usuario', 'UserController@edit')->name('user.edit');
        /*
            La siguiente ruta es para ver detalles de un usuario en especifico
        */
        Route::get('/Usuarios/Detalles/{user}/Usuario', 'UserController@show')->name('user.details');
        Route::post('/Usuarios/EditarUsuario/{user}','UserController@update')->name('user.update');
        Route::post('/Usuarios/DesactivarUsuario/{user}','UserController@destroy')->name('user.destroy');
        Route::post('Usuarios/ActividadesUsuario/{user}', 'AssignmentController@index')->name('assignments.users');



        //La siguiente sección es para la gestión de subáreas 

        Route::get('/SubAreas/{department}', 'SubareaController@index')->name('subarea.index');
        Route::post('/SubAreas/Agregar/{department}','SubareaController@store')->name('subarea.store');
        Route::get('/SubAreas/VerSubArea/{subarea?}', 'SubareaController@edit')->name('subarea.edit');
        Route::post('/SubAreas/EditarSubArea/{subarea}','SubareaController@update')->name('subarea.update');
        Route::post('/SubAreas/EliminarSubArea/{subarea}','SubareaController@destroy')->name('subarea.destroy');

        //La siguiente sección es para la gestión de actividades
        Route::get('/Actividades/{subarea}', 'ActivityController@index')->name('activity.index');
        Route::post('/Actividades/Agregar','ActivityController@store')->name('activity.store');
        Route::get('/Actividades/VerActividad/{subarea}/{activity}', 'ActivityController@edit')->name('activity.edit');
        Route::post('/Actividades/EditarActividad/{subarea}/{activity}','ActivityController@update')->name('activity.update');
        Route::post('/Actividades/EliminarActividad/{subarea}/{activity}','ActivityController@destroy')->name('activity.destroy');
        Route::post('Actividades/ActividadesUsuario/{activity}', 'AssignmentController@index')->name('assignments.activities');


        //La siguiente ruta es para hacer gestión de las actividades asignadas a usuarios y de los usuarios asignados a actividades
        Route::get('/AsignaciónActividadesUsuario/{user}','AssignmentController@index')->name('assignment.user');
        Route::get('/AsignaciónUsuarios/{activity}','AssignmentController@index')->name('assignment.activity');
        //Route::post('/Asignación/{user?}/{activity?}','AssignmentController@store')->name('assignment.store');
        //Asignación de una actividad a un usuario
        Route::post('/AsignaciónActividad/{user}','AssignmentController@storeActivity')->name('assignment.store.activity');
        //Asignación de un usuario a una actividad
        Route::post('/AsignaciónUsuario/{activity}','AssignmentController@storeAgent')->name('assignment.store.agent');
        Route::post('/Eliminación/{assignment}/{user?}/{activity?}','AssignmentController@destroy')->name('assignment.destroy');

        //La siguiente es para gestión de tickets

        //Esta ruta es para la bandeja de entrada por departamento
        Route::get('/Tickets/Bandeja/{department?}', 'TicketController@inbox')->name('ticket.inbox');
    
        //Esta ruta es para el historico de todos los departamentos
        Route::get('/Tickets/Histórico/{department?}', 'TicketController@historical')->name('ticket.historical');
        Route::get('/Tickets/NoAsignados/{department}', 'TicketController@notAssigned')->name('ticket.notAssigned');
        Route::get('/Tickets/Crear','TicketController@create')->name('ticket.create');
        Route::post('/Tickets/Agregar','TicketController@store')->name('ticket.store');
        //Esta ruta es para ver los detalles de un ticket en especifico
        Route::get('/Tickets/DetallesTicket/{ticket}/{option}', 'TicketController@show')->name('ticket.show');
        //Esta ruta es para redirigir a un formulario para editar un ticket en especifico
        Route::get('/Tickets/MostrarTicket/{ticket}/{option}', 'TicketController@edit')->name('ticket.edit');
        Route::post('/Tickets/EditarTicket/{ticket}/{option}','TicketController@update')->name('ticket.update');
        Route::post('/Tickets/EliminarTicket/{ticket}/{ticketOption}/{option}','TicketController@destroy')->name('ticket.destroy');
        Route::get('/Transferir/{ticket}/{option}','TicketController@toTransfer')->name('ticket.transfer');
        Route::post('/Reasignar/{ticket}/{option}','TicketController@reasign')->name('ticket.reasign');
        Route::get('/MisTickets/{employeeNumber}','TicketController@myTickets')->name('ticket.mytickets');
        Route::get('Tickets/subareas','SubareaController@getSubareas');
        Route::get('Tickets/activities','ActivityController@getActivities');




        //Muestra formulario para añadir un archivo
        Route::get('/Archivo/Crear/{ticket}','FileController@create')->name('file.create');
        //Muestra formulario para añadir archivo a tu ticket
        Route::get('/Archivo/CrearMiArchivo/{ticket}','FileController@create')->name('myfile.create');
        //Se crea la asignación del archivo al ticket
        Route::post('/Archivo/{ticket}','FileController@store')->name('file.store');

        Route::get('/DescargarArchivo/{file}','FileController@download')->name('file.download');

        Route::get('/Mensaje/Crear/{ticket}/{option}','MessageController@create')->name('message.create');
        Route::post('/Mensajes/{ticket}/{option}','MessageController@store')->name('message.store');
        //
    });
    





    Route::prefix('Asistente')->name('assistant.')->group(function()
    {
        
        Route::get('','UserController@homeAssistant')->name('home');

           //Ruta para mostrar el formulario de cambio de contraseña
        Route::get('/CambiarContraseña','UserController@changePassForm')->name('change.pass');
           //Ruta para actualizar contraseña
        Route::post('/ActualizarContraseña','UserController@updatePass')->name('update.pass');
        
        //En esta parte va el CRUD de todo tipo de usuario, coordinador, técnico, usuario
        Route::get('/Usuarios/{idRole}/{idDepartment?}', 'UserController@index')->name('user.index');
        Route::post('/Usuarios/Agregar','UserController@store')->name('user.store');
       /*La siguiente ruta nos sirve para mostrar no usuario, pasando como parametro su id,
            cuando la plantilla cargue, tendrá en ella adjuntada el objeto que se está deseando editar
            */
            
        Route::get('/Usuarios/Ver/{user}/Usuario', 'UserController@edit')->name('user.edit');

        /*
            La siguiente ruta es para ver detalles de un usuario en especifico
        */
        Route::get('/Usuarios/Detalles/{user}/Usuario', 'UserController@show')->name('user.details');
        Route::post('/Usuarios/EditarUsuario/{user}','UserController@update')->name('user.update');
        Route::post('/Usuarios/DesactivarUsuario/{user}','UserController@destroy')->name('user.destroy');
        Route::post('Usuarios/ActividadesUsuario/{user}', 'AssignmentController@index')->name('assignments.users');

        //La siguiente ruta es para hacer gestión de las actividades asignadas a usuarios y de los usuarios asignados a actividades
        Route::get('/AsignaciónActividadesUsuario/{user}','AssignmentController@index')->name('assignment.user');
        Route::get('/AsignaciónUsuarios/{activity}','AssignmentController@index')->name('assignment.activity');
        //Asignación de una actividad a un usuario
        Route::post('/AsignaciónActividad/{user}','AssignmentController@storeActivity')->name('assignment.store.activity');
        //Asignación de un usuario a una actividad
        Route::post('/AsignaciónUsuario/{activity}','AssignmentController@storeAgent')->name('assignment.store.agent');
        Route::get('/AsignaciónTemporal/{user}/{option}','AssignmentController@temporary')->name('user.status');
        Route::post('/AgregarSubareaTemporal/{agent}/{option}','AssignmentController@temporaryAssignmentAll')->name('assignment.temporary.all');
        Route::post('/AsignaciónTemporalActividad/{agent}/{option}','AssignmentController@temporaryAssignment')->name('assignment.temporary.activity');
        
        Route::post('/Eliminación/{assignment}/{user?}/{activity?}','AssignmentController@destroy')->name('assignment.destroy');



        
        //La siguiente es para gestión de tickets

         //Esta ruta es para la bandeja de entrada por departamento
         Route::get('/Tickets/Bandeja/{department?}', 'TicketController@inbox')->name('ticket.inbox');
            
         //Esta ruta es para el historico de todos los departamentos
         Route::get('/Tickets/Histórico/{department?}', 'TicketController@historical')->name('ticket.historical');
         Route::get('/Tickets/NoAsignados/{department}', 'TicketController@notAssigned')->name('ticket.notAssigned');
         Route::get('/Tickets/Crear','TicketController@create')->name('ticket.create');
         Route::post('/Tickets/Agregar','TicketController@store')->name('ticket.store');
         Route::get('/Tickets/DetallesTicket/{ticket}/{option}', 'TicketController@show')->name('ticket.show');
         Route::get('/Tickets/DetallesTicket/{ticket}', 'TicketController@edit')->name('ticket.edit');
         Route::post('/Tickets/EditarTicket/{ticket}','TicketController@update')->name('ticket.update');
         Route::post('/Tickets/EliminarTicket/{ticket}/{ticketOption}/{option}','TicketController@destroy')->name('ticket.destroy');
         Route::get('/MisTickets/{employeeNumber}','TicketController@myTickets')->name('ticket.mytickets');
         Route::get('Tickets/subareas','SubareaController@getSubareas');
         Route::get('Tickets/activities','ActivityController@getActivities');

         //Muestra formulario para añadir un archivo
         Route::get('/Archivo/Crear/{ticket}/{option}','FileController@create')->name('file.create');
         //Muestra formulario para añadir archivo a tu ticket
         //Route::get('/Archivo/CrearMiArchivo/{ticket}','FileController@create')->name('myfile.create');
         //Se crea la asignación del archivo al ticket
         Route::post('/Archivo/{ticket}/{option}','FileController@store')->name('file.store');

         Route::get('/DescargarArchivo/{file}','FileController@download')->name('file.download');


        //
    });



    Route::prefix('Agente')->name('agent.')->group(function()
    {
        
        Route::get('','UserController@homeAgent')->name('home');
           //Ruta para mostrar el formulario de cambio de contraseña
        Route::get('/CambiarContraseña','UserController@changePassForm')->name('change.pass');
           //Ruta para actualizar contraseña
        Route::post('/ActualizarContraseña','UserController@updatePass')->name('update.pass');



        //La siguiente es para gestión de tickets

        Route::get('/Tickets/{department}/{subarea}', 'TicketController@inbox')->name('ticket.inbox');
        Route::get('/Tickets/NoAsignados/{department}', 'TicketController@notAssigned')->name('ticket.notAssigned');
        Route::get('/Tickets/Crear','TicketController@create')->name('ticket.create');
        Route::post('/Tickets/Agregar','TicketController@store')->name('ticket.store');
        Route::get('/Tickets/DetallesTicket/{ticket}/{option}', 'TicketController@show')->name('ticket.show');
        Route::get('/Tickets/DetallesTicket/{ticket}', 'TicketController@edit')->name('ticket.edit');
        Route::post('/Tickets/EditarTicket/{ticket}','TicketController@update')->name('ticket.update');
        Route::post('/Tickets/EliminarTicket/{ticket}/{ticketOption}/{option}','TicketController@destroy')->name('ticket.destroy');
        Route::get('/TicketsPorAtender/{user}','TicketController@ticketsForAttend')->name('ticket.attend');
        Route::get('/Transferir/{ticket}/{option}','TicketController@toTransfer')->name('ticket.transfer');
        Route::post('/Reasignar/{ticket}/{option}','TicketController@reasign')->name('ticket.reasign');
        Route::get('/AtenderTicket/{user}/{ticket}','TicketController@ticketsTechnician')->name('ticket.technician');
        Route::get('/AyudaDepartamento/{user}','TicketController@help')->name('ticket.help');
        Route::get('/TicketsAsignados/{user}','TicketController@ticketsAgent')->name('ticket.assignment');
        Route::get('/MisTickets/{employeeNumber}','TicketController@myTickets')->name('ticket.mytickets');
        Route::get('Tickets/subareas','SubareaController@getSubareas');
        Route::get('Tickets/activities','ActivityController@getActivities');

        //Muestra formulario para añadir un archivo
        Route::get('/Archivo/Crear/{ticket}/{option}','FileController@create')->name('file.create');
        //Muestra formulario para añadir archivo a tu ticket
        Route::get('/Archivo/CrearMiArchivo/{ticket}','FileController@create')->name('myfile.create');
        //Se crea la asignación del archivo al ticket
        Route::post('/Archivo/{ticket}/{option}','FileController@store')->name('file.store');

        Route::get('/DescargarArchivo/{file}','FileController@download')->name('file.download');

        Route::get('/Mensaje/Crear/{ticket}/{option}','MessageController@create')->name('message.create');
        Route::post('/Mensajes/{ticket}/{option}','MessageController@store')->name('message.store');

    });


    Route::prefix('Usuario')->name('user.')->group(function()
    {
        Route::get('','UserController@homeUser')->name('home');
         //Ruta para mostrar el formulario de cambio de contraseña
         Route::get('/CambiarContraseña','UserController@changePassForm')->name('change.pass');
         //Ruta para actualizar contraseña
         Route::post('/ActualizarContraseña','UserController@updatePass')->name('update.pass');
        
        
        
        Route::get('/Tickets/Crear','TicketController@create')->name('ticket.create');
        Route::post('/Tickets/Agregar','TicketController@store')->name('ticket.store');
        Route::get('/Tickets/DetallesTicket/{ticket}/{option}', 'TicketController@show')->name('ticket.show');
        Route::get('/Tickets/DetallesTicket/{ticket}', 'TicketController@edit')->name('ticket.edit');
        Route::post('/Tickets/EditarTicket/{ticket}','TicketController@update')->name('ticket.update');
        
        Route::get('/MisTickets/{employeeNumber}','TicketController@myTickets')->name('ticket.mytickets');
        Route::get('Tickets/subareas','SubareaController@getSubareas');
        Route::get('Tickets/activities','ActivityController@getActivities');
        //Muestra formulario para añadir un archivo
        Route::get('/Archivo/Crear/{ticket}','FileController@create')->name('file.create');
        //Muestra formulario para añadir archivo a tu ticket
        Route::get('/Archivo/CrearMiArchivo/{ticket}','FileController@create')->name('myfile.create');
        //Se crea la asignación del archivo al ticket
        Route::post('/Archivo/{ticket}','FileController@store')->name('file.store');

        Route::get('/DescargarArchivo/{file}','FileController@download')->name('file.download');

        Route::get('/Mensaje/Crear/{ticket}/{option}','MessageController@create')->name('message.create');
        Route::post('/Mensajes/{ticket}/{option}','MessageController@store')->name('message.store');

        //Encuesta
        Route::post('/Evaluar/{ticket}','PollController@store')->name('poll.store');

    });
  

});
    

Auth::routes();
Route::prefix('Invitado')->name('guest.')->group(function()
    {

        
        Route::get('Tickets/subareas','SubareaController@getSubareas');
        Route::get('Tickets/activities','ActivityController@getActivities');
        Route::get('/Tickets/Crear','TicketController@createG')->name('ticket.create');
        Route::post('/Tickets/Agregar','TicketController@storeG')->name('ticket.store');
        //Route::post('/Tickets/DetallesTicket/{ticket?}', 'TicketController@index')->name('ticket.index');
        Route::get('/Ver/Ticket/{ticket?}', 'TicketController@index')->name('ticket.index');
        Route::get('/Tickets/EditarTicket/{ticket}','TicketController@updateG')->name('ticket.update');
        Route::get('/Tickets/EliminarTicket/{ticket?}/{ticketOption?}','TicketController@destroyG')->name('ticket.destroy');
          
        
        Route::get('/CrearArchivo/{ticket}','FileController@createG')->name('file.create');
        Route::post('/AgregarArchivo/{ticket}','FileController@storeG')->name('file.store');
        
        Route::get('/CrearMensaje/{ticket}','MessageController@createG')->name('message.create');
        Route::post('/AñadirMensaje/{ticket}','MessageController@storeG')->name('message.store');
    
    
    });
    



