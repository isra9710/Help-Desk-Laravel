<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Role;
use App\Models\Subarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $departments = Department::paginate(2);
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        return view('management.department.index',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'departments'=>$departments]);
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
    public function store(Request $request)
    {
        //
        $status = 'success';
        $content= 'Se agregó departamento';
        try{
            $department = new Department();
            $department->departmentName =$request->departmentName;
            $department->departmentDescription  = $request->departmentDescription;
            $department->save();
        }catch(\Throwable $th){
            DB::rollBack();
            $status = 'error';
            $content= 'Error al intentar registrar departamento';  
            }
       return redirect()
       ->route('administrator.department.index')
       ->with('process_result',[
        'status'=>$status,
        'content'=>$content
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //  
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        return view('management.department.edit',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'department'=>$department]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        //
        $status = 'success';
        $content= 'Se editó departamento';
        try{
            $department->departmentName=$request->departmentName;
            $department->departmentDescription=$request->departmentDescription;
            $department->update();
        }catch(\Throwable $th){
            DB::rollBack();
            $status = 'error';
            $content= 'Error al intentar editar departamento';  
            }
        return redirect()
        ->route('administrator.department.index')
        ->with('process_result',[
            'status'=>$status,
            'content'=>$content
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        //
        $status = 'success';
        $content= '';
        try{
            if($department->active){
                $content='Se desacivó departamento';
                $department->active = FALSE;
            }
            else{
                $content='Se activó departamento';
                $department->active = TRUE;
            }
            $department->update();
        }catch(\Throwable $th){
            DB::rollBack();
            $status = 'error';
            $content= 'Error al intentar actualizar departamento';  
            }
        return redirect()
        ->route('administrator.department.index')
        ->with('process_result',[
            'status'=>$status,
            'content'=>$content
            ]);
    }

}
