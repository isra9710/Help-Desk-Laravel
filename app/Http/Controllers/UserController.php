<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        //
        return view('layouts.test');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @param  int  $role
     */
    public function index($role)
    {
        //
        
        $users = User::where('idRole', $role)->paginate(3);
        return view('admin.user.index',[ 'users'=>$users,'role'=>$role]);
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
        //$user->firstname= $request->firstname;
        //$user->lastname=$request->lastname;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->username=$request->username;
        $user->password=bcrypt($request->password);
        $user->idRole=$request->type;
        $user->extension=$request->extension;
        $user->status=TRUE;
        $user->save();
        return redirect()->route('admin.user.index',$user->role);
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
        return view('admin.user.edit',[
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
        return view('admin.user.show',[
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
        return redirect()->route('admin.user.index',$user->idRole);
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
        return redirect()->route('admin.user.index',$role);
    }
}
