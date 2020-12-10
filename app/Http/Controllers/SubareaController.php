<?php

namespace App\Http\Controllers;

use App\Models\Subarea;
use App\Models\Department;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $status = 'success';//Estado por defecto de mensajes 
        $content = 'Se registró subárea con éxito';//Contenido del mensaje por defecto
        try{
            $subarea = new Subarea();
            $subarea->subareaName = $request->subareaName;
            $subarea->idDepartment= $department->idDepartment;
            $subarea->subareaDescription=$request->subareaDescription;
            $subarea->save();
        }catch(\Throwable $th){
            DB::rollBack();
            $status = 'error';
            $content= 'Error al intentar registrar subárea';
            }
        if(Auth()->user()->isAdministrator()){
            return redirect()
            ->route('administrator.subarea.index',['department'=>$department])
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
        else{
            return redirect()
            ->route('coordinator.subarea.index',['department'=>$department])
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subarea  $subarea
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department,Subarea $subarea)
    {
        //
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        return view ('management.subarea.edit',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'subarea'=>$subarea,'department'=>$department]);
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
        $status = 'success';//Estado por defecto de mensajes 
        $content = 'Se editó subárea con éxito';//Contenido del mensaje por defecto
        try{
            $subarea->subareaName = $request->subareaName;
            $subarea->subareaDescription = $request->subareaDescription;
            $subarea->update();   
        }catch(\Throwable $th){
            DB::rollBack();
            $status = 'error';
            $content= 'Error al intentar editar subárea';
        }
        
        if(Auth()->user()->isAdministrator()){
            return redirect()->route('administrator.subarea.index',['department'=>$department])
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
        else{
            return redirect()->route('coordinator.subarea.index',['department'=>$department])
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
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
        $status = 'success';//Estado por defecto de mensajes 
        $content = '';//Contenido del mensaje por defecto
            if($subarea->active){
                try{
                    $content='Se desactivó subárea';
                    $subarea->active = FALSE;
                    $subarea->update();
                 }catch(\Throwable $th){
                    DB::rollBack();
                    $status = 'error';
                    $content= 'Error al intentar desactivar subárea';
                } 
                if(Auth()->user()->isAdministrator()){
                    return redirect()
                    ->route('administrator.subarea.index',['department'=>$department])
                    ->with('process_result',[
                        'status'=>$status,
                        'content'=>$content
                    ]);
                }
                else{
                    return redirect()
                    ->route('coordinator.subarea.index',['department'=>$department])
                    ->with('process_result',[
                        'status'=>$status,
                        'content'=>$content
                    ]);
                }
            }
            else{
                try{
                    $content='Se reactivó subárea';
                    $subarea->active = TRUE;
                    $subarea->update();
                }catch(\Throwable $th){
                    DB::rollBack();
                    $status = 'error';
                    $content= 'Error al intentar reactivar subárea';
                }
                return redirect()
                ->route('administrator.subarea.index',['department'=>$department])
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);

            }
    }

  
}
