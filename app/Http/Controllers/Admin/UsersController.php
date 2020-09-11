<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\Admin\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexE()
    {
        //
        $users = User::paginate(5);
        return view('admin.user.index',[ 'users'=>$users,]);
        //return 'Lista';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexT()
    {
        //
        $users = User::paginate(5)->where('idUser', 2);
        return view('admin.user.index',[ 'users'=>$users,]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createE(Request $request)
    {
        //
        $user = new User();
        $user->firstname= $request->firstname;
        $user->lastname=$request->lastname;
        $user->email=$request->email;
        $user->username=$request->username;
        $user->password=bcrypt($request->password);
        $user->idTypeU=3;
        $user->save();
        return redirect()->route('admin.user.indexE');
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
    public function showE( $id)
    {
        //
        $user = User::where('idUser', $id)->first();
        return view('admin.user.show',[
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function editeE($id)
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
    public function updateE($id,Request $request)
    {
        //
        $id=$request->idUser;
        $user = User::where('idUser', $request->id)->first();
        $user->firstname= $request->firstname;
        $user->idUser = $request->idUser;
        $user->lastname=$request->lastname;
        $user->email=$request->email;
        $user->username=$request->username;
        $user->save();
        return redirect()->route('admin.user.indexE');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyE($id)
    {
        //
        User::destroy($id);
        return redirect()->route('admin.user.indexE');
    }
}
