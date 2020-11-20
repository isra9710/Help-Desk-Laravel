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
        $subareas = "";
        if(auth()->user()->isAdministrator()){
            $subareas = Subarea::where('idDepartment', $department->idDepartment)->paginate(3);
        }
        else{
            $subareas = Subarea::where('idDepartment', $department->idDepartment)->where('active',TRUE)->paginate(3);
        }        
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        return view('management.subarea.index',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'subareas'=>$subareas,'department'=>$department]);
    }


    public function getSubareas(Request $request)
    {
        if($request->ajax()){
            $subareas = Subarea::where('idDepartment',$request->idDepartment)->where('active',TRUE)->get(); 
            foreach($subareas as $subarea) {
                $subareasArray[$subarea->idSubarea]=$subarea->subareaName;
            }
            return response()->json($subareasArray);
        }
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Department $department,Request $request)
    {
        //
        $subarea = new Subarea();
        $subarea->subareaName = $request->subareaName;
        $subarea->idDepartment= $department->idDepartment;
        $subarea->save();
        if(Auth()->user()->isAdministrator()){
            return redirect()->route('administrator.subarea.index',['department'=>$department]);
        }
        else{
            return redirect()->route('coordinator.subarea.index',['department'=>$department]);
        }
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
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $departmentsSideBar = Department::where('active',TRUE)->get();
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
        $subarea->subareaDescription = $request->subareaDescription;
        $subarea->update();
        if(Auth()->user()->isAdministrator()){
            return redirect()->route('administrator.subarea.index',['department'=>$department]);
        }
        else{
            return redirect()->route('coordinator.subarea.index',['department'=>$department]);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subarea  $subarea
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department, Subarea $subarea)
    {
        //
        if($subarea->active){
            $subarea->active = FALSE;
            $subarea->update();
            if(Auth()->user()->isAdministrator()){
                return redirect()->route('administrator.subarea.index',['department'=>$department]);
             }
            else{
                return redirect()->route('coordinator.subarea.index',['department'=>$department]);
             }
        }
        else{
            $subarea->active = TRUE;
            $subarea->update();
            return redirect()->route('administrator.subarea.index',['department'=>$department]);

        }
        
    }

    public function reactivate(Department $department, Subarea $subarea)
    {
        $subarea->active = True;
        $subarea->update();
        return redirect()->route('administrator.subarea.index',['department'=>$department]);
        
      
    }
}
