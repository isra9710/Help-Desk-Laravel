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

       /*if (Auth()->user()->hasRole("Administrador")) {
           return view('administrator.home');
        }*/

        if (Auth()->user()->hasRole("Administrador")) {
            
            return redirect()->route('administrator.home');
         }
        elseif(Auth()->user()->hasRole("Coordinador")) {
            return redirect()->route('coordinator.home');
        }
        elseif(Auth()->user()->hasRole("Asistente")) {
            return '/Asistente';
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

    function homeAdministrator()
    {
        $departments = Department::all();
        $roles = Role::all();
        return view('home', ['departments'=>$departments,'roles'=>$roles]);
    }

    function homeCoordinator()
    {
        $roles =Role::all();
        return view('home',['roles' => $roles]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @param  int  $role
     * @param int $department
     */
    public function index($role, $department=null)
    {
        //
        $users = ""; 
        $users = User::where('idRole', $role)->where('idDepartment', $department)->paginate(3);
        if($role == 5 || $role ==6) //Si es un usuario o invitado, no necesitamos ningún filtro, pues estos no pertenecen a algún departamento en especificoß
        {
            $users = User::where('idRole', $role)->paginate(3);
            
        }
        $departments = Department::all();
        $roles = Role::all();
        return view('management.user.index',[ 'users'=>$users,'role'=>$role, 'departments'=>$departments, 'roles'=>$roles]);
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
        $user->name=$request->name;
        $user->email=$request->email;
        $user->username=$request->username;
        $user->password=bcrypt($request->password);
        $user->idRole=$request->type;
        $user->extension=$request->extension;
        $user->status=TRUE;
        if(Auth()->user()->isAdmin()){

        }
        $user->save();
        return redirect()->route('administrator.user.index',$user->role);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $departments = Department::all();
        $roles = Role::all();
        $user = User::where('idUser', $id)->first();
        return view('management.user.edit',[
            'user' => $user, 'departments' => $departments, 'roles' => $roles
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edite($id)
    {
        //
        $departments = Department::all();
        $roles = Role::all();
        $user = User::where('idUser', $id)->first();
        return view('management.user.show',[
            'user' => $user, 'departments' => $departments, 'roles' => $departments
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        //
        $user = User::where('idUser', $request->id)->first();
        $user->firstname= $request->firstname;
        $user->lastname=$request->lastname;
        $user->email=$request->email;
        $user->username=$request->username;
        $user->save();
        if(auth()->user()->isAdministrator())
            return redirect()->route('administrator.user.index',$user->idRole);
        else    
            return redirect()->route('coordinator.user.index',$user->idRole);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::where('idUser', $id)->first();
        $role = $user->idRole;
        User::destroy($id);
        if(auth()->user()->isAdministrator())
            return redirect()->route('administrator.user.index',$user->idRole);
        else    
            return redirect()->route('coordinator.user.index',$user->idRole);
    }


   
}
