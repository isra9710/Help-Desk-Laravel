<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use App\Models\Department;
use App\Models\Role;

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
            return redirect()->route('assistant.home');;
        }
        elseif(Auth()->user()->hasRole("Agente")) {
            return '/Agente';
        }
        elseif(Auth()->user()->hasRole("Usuario")) {
            return '/Usuario';
        }
        else {
            return '/Invitado';
        }
        return view('welcome');
    }
    //Nos retornara a la página principal del administrador, trayendo consigo, departamentos, roles de usuario
    function homeAdministrator()
    {
        $departments = Department::all();
        $roles = Role::all();
        return view('home', ['departments'=>$departments,'roles'=>$roles]);
    }

    //Nos retornará a la página principal del coordinador de departamento, trayendo consigo los roles de usuario del departamento

    function homeCoordinator()
    {
        $roles =Role::all();
        return view('home',['roles' => $roles]);
    }

    //Nos retornará a la página principal del asistente trayendo consigo roles de usuario
    function homeAssistant()
    {
        $roles =Role::all();
        return view('home',['roles' => $roles]);
    }


    function homeAgent()
    {
        $roles =Role::all();
        return view('home',['roles' => $roles]);
    }


    function homeUser()
    {
        $roles =Role::all();
        return view('home',['roles' => $roles]);
    }


    function homeGuest()
    {
        $roles =Role::all();
        return view('home',['roles' => $roles]);
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
    public function index($idRole, $idDepartment=null)
    {
        //
        $users = "";

        $users = User::where('idRole', $idRole)->where('idDepartment', $idDepartment)->paginate(3);
        if($idRole == 5 || $idRole ==6) //Si es un usuario o invitado, no necesitamos ningún filtro, pues estos no pertenecen a algún departamento en especificoß
        {
            $users = User::where('idRole', $idRole)->paginate(3);

        }
        /*
        Hacemos estas consultas sólo para la parte estetica, si se trata de un administrador
        necesitaremos departamentos, si se trata de un coordinador o asistente, sólo necesitaremos roles
        */
        $departments = Department::all();
        $roles = Role::all();
        
        return view('management.user.index',[ 'users'=>$users,'idRole'=>$idRole, 'departments'=>$departments, 'roles'=>$roles, 'idDepartment'=>$idDepartment]);
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $user = new User();
        /*
        Los siguiente datos los obtenemos del formulario de registro ubicado en managment.user.index
        */
        $user->name=$request->name;
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
        }
        $user->save();
        if(Auth()->user()->isAdministrator()){
            return redirect()->route('administrator.user.index',[$user->role,$user->idDepartment]);
        }
        elseif(Auth()->user()->isCoordinator()){
            return redirect()->route('coordinator.user.index',[$user->role,$user->idRole]);
        }
        else{
            return redirect()->route('assistant.user.index',[$user->role,$user->idRole]);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        //
        
        return null;
    }

  
    /**
     * Display the specified resource.
     *
     * @param  int  $idUsuario
     * @return \Illuminate\Http\Response
     */
    /*La siguiente función nos redirigirá al formulario con los datos del usuario que elegimos
    
    */
    
     public function show( $idUsuario=null){
        /*
            De nueva cuenta hacemos la consulta de todos los departamentos para no perderlos
            y si es un usuario administrador, que no los pierda, igual si es un usuario coordinador o asistente
            para éso se hace la consulta de los roles
        */
        $departments = Department::all();
        $roles = Role::all();
        $user = User::where('idUser', $idUsuario)->first();
        $role = $user->idRole;
        return view('management.user.edit', compact('user','roles','departments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edite($id)
    {
        //
        return null;
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
    public function update($id,Request $request)
    {
        //
        /*
            Se hace la consulta del usuario que queremos editar, la función first nos permite obtener un solo
            objeto para no obtener una colección de la consulta
        */
        $user = User::where('idUser', $request->id)->first();
        $user->firstname= $request->firstname;
        $user->lastname=$request->lastname;
        $user->email=$request->email;
        $user->username=$request->username;
        $user->save();

        /*En las siguientes líneas se redirige al usuario a su dirección correspondiente 
          dependiendo del rol que éste tenga
        */
        if(Auth()->user()->isAdministrator()){
            return redirect()->route('administrator.user.index',$user->role);
        }
        elseif(Auth()->user()->isCoordinator()){
            return redirect()->route('coordinator.user.index',$user->role);
        }
        else{
            return redirect()->route('assistant.user.index',$user->role);
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
    public function destroy($id)
    {
        //
        $user = User::where('idUser', $id)->first();
        $role = $user->idRole;
        $department=$user->idDepartment;
        User::destroy($id);
        if(Auth()->user()->isAdministrator()){
            return redirect()->route('administrator.user.index',['role'=>$role, 'department'=>$department]);
        }
        elseif(Auth()->user()->isCoordinator()){
            return redirect()->route('coordinator.user.index',['role'=>$role, 'department'=>$department]);
        }
        else{
            return redirect()->route('assistant.user.index',['role'=>$role, 'department'=>$department]);
        }
    }



}
