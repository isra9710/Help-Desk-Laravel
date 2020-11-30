<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use App\Models\Department;
use App\Models\Role;
use App\Models\Subarea;
use App\Controllers\AssignmentController;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Función que nos retornará a la página principal del Usuario
    public function home()
    {
        //
        if (Auth()->user()->isAdministrator()) {

            return redirect()->route('administrator.home');
         }
        elseif(Auth()->user()->isCoordinator()) {
            return redirect()->route('coordinator.home');
        }
        elseif(Auth()->user()->isAssistant()) {
            return redirect()->route('assistant.home');
        }
        elseif(Auth()->user()->isAgent()) {
            return redirect()->route('agent.home');
        }
        elseif(Auth()->user()->isUser()) {
            return redirect()->route('user.home');
        }
        else {
            return '/Invitado';
        }
        
    }


    
    //Nos retornara a la página principal del administrador, trayendo consigo, departamentos, roles de usuario
    function homeAdministrator()
    {
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        return view('home', ['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar]);
    }

    
    //Nos retornará a la página principal del coordinador de departamento, trayendo consigo los roles de usuario del departamento

    function homeCoordinator()
    {
        $rolesSideBar =Role::all();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        return view('home',['rolesSideBar' => $rolesSideBar,'subareasSideBar'=>$subareasSideBar]);
    }

    //Nos retornará a la página principal del asistente trayendo consigo roles de usuario
    function homeAssistant()
    {
        $rolesSideBar=Role::all();
        return view('home',['rolesSideBar' => $rolesSideBar]);
    }


    function homeAgent()
    {
        return view('home');
    }


    function homeUser()
    {
        return view('home');
    }


    function homeGuest()
    {
        return view('home');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @param  int  $idRole
     * @param int $idDepartment
     */

    /*Esta función nos retornará al index dependiendo de qué tipo de usuario se seleccionó
     Si es un administrador quien está haciendo esta petición, mediante la vista ubicada en layouts.sidebar
     obtendremos rol y departamento, si es un coordinador, de la misma vista obtendremos el dato de rol, 
     porque el coordinador sólo puede hacer gestión de los usuarios que pertenecen a su departamento
     y por último el asistente sólo podrá hacer gestión de los agentes de su departamento
    */
    public function index($idRole=null, $idDepartment=null)
    {
        //
        $users = "";
        $subareas = NULL;
        if(auth()->user()->isAdministrator()){
            $users = User::where('idRole', $idRole)->where('idDepartment', $idDepartment)->paginate(3);
        }
        else{
            $users = User::where('idRole', $idRole)->where('idDepartment', $idDepartment)->where('active',TRUE)->paginate(3);
        }
        
        if($idRole == 5 || $idRole ==6) //Si es un usuario o invitado, no necesitamos ningún filtro, pues estos no pertenecen a algún departamento en especificoß
        {
            if(auth()->user()->isAdministrator()){
            $users = User::where('idRole', $idRole)->paginate(3);
            }
            else{
                $users = User::where('idRole', $idRole)->where('active',TRUE)->paginate(3);
            }
        }
        if($idRole==4){
                $subareas = Subarea::where('idDepartment',$idDepartment)->where('active',TRUE)->get();
            }
        
        /*
        Hacemos estas consultas sólo para la parte estetica, si se trata de un administrador
        necesitaremos departamentos, si se trata de un coordinador o asistente, sólo necesitaremos roles
        */
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        return view('management.user.index',['departmentsSideBar'=>$departmentsSideBar, 'rolesSideBar'=>$rolesSideBar, 'subareasSideBar'=>$subareasSideBar,'users'=>$users,'idDepartment'=>$idDepartment,'idRole'=>$idRole,'subareas'=>$subareas]);
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return null;
      
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $user = new User();
        $status = 'success';//Estado por defecto de mensajes 
        $content = 'Se registró usuario con éxito';//Contenido del mensaje por defecto
        /*
        Los siguiente datos los obtenemos del formulario de registro ubicado en managment.user.index
        */
        try{
            $user->name=$request->name;
            $user->fathersLastName = "X";
            $user->mothersLastName ="X";
            $user->email=$request->email;
            $user->username=$request->username;
            $user->password=bcrypt($request->password);
            $user->idRole=$request->idRole;
            $user->extension=$request->extension;
            $user->status=TRUE;
            $idDepartment = $request->idDepartment;
            /*Si el departamento no es null, quiere decir que estamos queriendo registrar a un coordinador, agente o 
            asistente, por éso nos importa saber si es null o no, de otro modo, estamos hablando de un usuario normal
            */
            if(!($idDepartment == null)){  
                $user->idDepartment = $idDepartment;
                $dep = Department::where('idDepartment',$idDepartment)->first();
             
                if($request->idRole==2){
                    $content='Coordinador para '.$dep->departmentName.' se registró con éxito';
                }
                elseif($request->idRole==3){
                    $content='Asistente para '.$dep->departmentName.' se registró con éxito';
                }
                else{ 
                    $content='Agente para '.$dep->departmentName.' se registró con éxito';
                }
            }
            $user->save();
 
            if($request->idRole==4)
            {
                
                app()->call('App\Http\Controllers\AssignmentController@store', ['user'=>$user,'idSubarea'=>$request->idSubarea]);
            }
        }catch(\Throwable $th){
            DB::rollBack();
            $status = 'error';
            $content= 'Error al intentar registrar usuario';
        }
        if(Auth()->user()->isAdministrator()){
            return redirect()
            ->route('administrator.user.index',[$user->role,$user->idDepartment])
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
        elseif(Auth()->user()->isCoordinator()){
            return redirect()
            ->route('coordinator.user.index',[$user->role,$user->idDepartment])
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
        else{
            return redirect()
            ->route('assistant.user.index',[$user->role,$user->idDepartment])
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
    }

  
    /**
     * Display the specified resource.
     *
     * @param  int  $idUsuario
     * @return \Illuminate\Http\Response
     */
    /*La siguiente función nos redirigirá al formulario con los datos del usuario que elegimos
    
    */
    
     public function show(User $user){

      $departmentsSideBar = Department::where('active',TRUE)->get();
      $subareasSideBar = Subarea::where('active',TRUE)->get();
      $rolesSideBar = Role::all();
      return view('management.user.details',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
          /*
            De nueva cuenta hacemos la consulta de todos los departamentos para no perderlos
            y si es un usuario administrador, que no los pierda, igual si es un usuario coordinador o asistente
            para éso se hace la consulta de los roles
        */
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        return view('management.user.edit',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /*
        La siguiente función es la que realmente actualiza los datos del usuario
        recolectando estos mismos del formulario ubicado en managment.user.edit
    */
    public function update(User $user,Request $request)
    {
        //
        $status = 'success';//Estado por defecto de mensajes 
        $content = 'Se editó usuario con éxito';//Contenido del mensaje por defecto
        /*
            Se hace la consulta del usuario que queremos editar, la función first nos permite obtener un solo
            objeto para no obtener una colección de la consulta
        */
        try{
            $idRole = $user->idRole;
            $idDepartment = $user->idDepartment;
            $user->username=$request->username;
            $user->name=$request->name;
            $user->email=$request->email;
            if($user->idDepartment){
                $dep = Department::where('idDepartment',$user->idDepartment)->first();
                if($user->idRole==2){
                    $content='Se editó correctamento coordinador de '.$dep->departmentName;
                }
                elseif($user->idRole==3){
                    $content='Se editó correctamento asistente de '.$dep->departmentName;
                }
                else{
                    $content='Se editó correctamento agente de '.$dep->departmentName;
                }
            }
            $user->update();
        }catch(\Throwable $th){
            DB::rollBack();
            $status = 'error';
            $content= 'Error al intentar editar usuario';
        }
        /*En las siguientes líneas se redirige al usuario a su dirección correspondiente 
          dependiendo del rol que éste tenga
        */
        if(Auth()->user()->isAdministrator()){
            return redirect()
            ->route('administrator.user.index',['idRole'=>$idRole, 'idDepartment'=>$idDepartment])
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
        elseif(Auth()->user()->isCoordinator()){
            return redirect()
            ->route('coordinator.user.index',['idRole'=>$idRole, 'idDepartment'=>$idDepartment])
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
        else{
            return redirect()
            ->route('assistant.user.index',['idRole'=>$idRole, 'idDepartment'=>$idDepartment])
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /*La siguiente función es para eliminar un usuario, se pasa el id como parametro que nos ayudará 
     a buscarlo para después eliminarlo
     
     */
    public function destroy(User $user)
    {
        $status = 'warning';//Estado por defecto de mensajes 
        $content = '';//Contenido del mensaje por defecto
        if($user->active){
            
            try{
                $user->active= FALSE;
                $content='Se desactivó usuario con éxito';
                if($user->idDepartment){
                    $dep = Department::where('idDepartment',$user->idDepartment)->first();
                    if($user->idRole==2){
                        $content='Se desactivó correctamente coordinador de '.$dep->departmentName;
                    }
                    elseif($user->idRole==3){
                        $content='Se desactivó correctamente asistente de '.$dep->departmentName;
                    }
                    else{
                        $content='Se desactivó correctamento agente de '.$dep->departmentName;
                    }
                }
                $user->update();
            }catch(\Throwable $th){
                DB::rollBack();
                $status = 'error';
                $content= 'Error al intentar desactivar usuario';
            }
            
            
        
            if(Auth()->user()->isAdministrator()){
                return redirect()
                ->route('administrator.user.index',['idRole'=>$user->idRole, 'idDepartment'=>$user->idDepartment])
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            elseif(Auth()->user()->isCoordinator()){
                return redirect()
                ->route('coordinator.user.index',['idRole'=>$user->idRole, 'idDepartment'=>$user->idDepartment])
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            else{
                return redirect()
                ->route('assistant.user.index',['idRole'=>$user->idRole, 'idDepartment'=>$user->idDepartment])
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
        }
        else{
            try{
                $user->active= TRUE;
                $content='Se reactivó usuario con éxito';
                if($user->idDepartment){
                    $dep = Department::where('idDepartment',$user->idDepartment)->first();
                    if($user->idRole==2){
                        $content='Se reactivó correctamente coordinador de '.$dep->departmentName;
                    }
                    elseif($user->idRole==3){
                        $content='Se reactivó correctamente asistente de '.$dep->departmentName;
                    }
                    else{
                        $content='Se reactivó correctamento agente de '.$dep->departmentName;
                    }
                }
            $user->update();
            }catch(\Throwable $th){
                DB::rollBack();
                $status = 'error';
                $content= 'Error al intentar reactivar usuario';
            }
            return redirect()
            ->route('administrator.user.index',['idRole'=>$user->idRole, 'idDepartment'=>$user->idDepartment])
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
    }

 

  



}
