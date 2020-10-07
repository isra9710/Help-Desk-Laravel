<?php

namespace App\Http\Controllers;

use App\Models\Subarea;
use App\Models\Department;
use App\Models\Role;
use Illuminate\Http\Request;

class SubareaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Department $department)
    {
        //
        $subareas = Subarea::where('idDepartment', $department->idDepartment)->paginate(3);
        $subareasSideBar = Subarea::all();
        $departmentsSideBar = Department::all();
        $rolesSideBar = Role::all();
        return view('management.subarea.index',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'subareas'=>$subareas,'department'=>$department]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Department $department, Request $request)
    {
        //
        $subarea = new Subarea();
        $subarea->subareaName = $request->subareaName;
        $subarea->idDepartment= $department->idDepartment;
        $subarea->save();
        return redirect()->route('administrator.subarea.index',['department'=>$department]);

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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subarea  $subarea
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department,Subarea $subarea)
    {
        //
        $subareasSideBar = Subarea::all();
        $departmentsSideBar = Department::all();
        $rolesSideBar = Role::all();
        return view ('management.subarea.edit',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'subarea'=>$subarea,'department'=>$department]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subarea  $subarea
     * @return \Illuminate\Http\Response
     */
    public function edit(Subarea $subarea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subarea  $subarea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department,Subarea $subarea)
    {
        //
        $subarea->subareaName = $request->subareaName;
        $subarea->update();
        return redirect()->route('administrator.subarea.index',['department'=>$department]); 
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subarea  $subarea
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department,Subarea $subarea)
    {
        //
        Subarea::destroy($subarea->idSubarea);
        return redirect()->route('administrator.subarea.index',['department'=>$department]);
    }
}
