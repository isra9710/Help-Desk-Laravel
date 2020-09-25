<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use App\Models\Department;

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
            return redirect()->route('administrator.home');
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
        return view('home');
    }

    function homeCoordinator()
    {
        return view('home');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @param  int  $role
     */
    public function index($role, $department=null)
    {
        //
        $users = "";
        if(Auth()->user()->isAdministrator())//Al administrador sólo se le harán dos filtros para mostrar menos cantidad de información
        {
            
            $users = User::where('idRole', $role)->where('idDepartment', $department)->paginate(3);
        }
        elseif($role == 5 || $role == 6)//Si es un usuario o invitado, no necesitamos ningún filtro, pues estos no pertenecen a algún departamento en especificoß
        {
            $users = User::where('idRole', $role)->paginate(3);
        }
        else{
            //$department = Department::firstWhere('idDepartment', Auth()->user()->idDepartment);
            $users = User::where('idRole', $role)->where('idDepartment', Auth()->user()->idDepartment)->paginate(3);
        }
        
        return view('management.user.index',[ 'users'=>$users,'role'=>$role]);
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
    public function show( $id)
    {
        //
        $user = User::where('idUser', $id)->first();
        return view('administrator.user.edit',[
            'user' => $user
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
        $user = User::where('idUser', $id)->first();
        return view('administrator.user.show',[
            'user' => $user
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
        return redirect()->route('administrator.user.index',$user->idRole);
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
        return redirect()->route('administrator.user.index',$role);
    }


   
}
