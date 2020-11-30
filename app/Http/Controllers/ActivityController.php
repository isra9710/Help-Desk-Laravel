<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Department;
use App\Models\Subarea;
use App\Models\Role;
use App\Models\Priority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Subarea $subarea)
    {
        //
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        $priorities = Priority::all();
        $activities = "";
        if(auth()->user()->isAdministrator()){
            $activities = Activity::where('idSubarea',$subarea->idSubarea)->paginate(3);
        }
        else{
            $activities = Activity::where('idSubarea',$subarea->idSubarea)->where('active',TRUE)->paginate(3);
        }
        
        return view('management.activity.index',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'activities'=>$activities,'subarea'=>$subarea,'priorities'=>$priorities]);
    }


    public function getActivities(Request $request)
    {
        if ($request->ajax()) {
            $activities = Activity::where('idSubarea', $request->idSubarea)->get();
            foreach ($activities as $activity) {
                $activitiesArray[$activity->idActivity] = $activity->activityName;
            }
            return response()->json($activitiesArray);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Subarea $subarea, Request $request)
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Subarea $subarea, Request $request)
    {
        //
        $activity = new Activity();
        $activity->activityName = $request->activityName;
        $activity->idSubarea =  $subarea->idSubarea;
        $activity->idPriority = $request->idPriority;
        $activity->days = $request->days;
        $activity->activityDescription = $request->activityDescription;
        $activity->save();
        return redirect()->route('administrator.activity.index',['subarea'=>$subarea]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Subarea $subarea, Activity $activity)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Subarea $subarea, Activity $activity)
    {
        //
         //
         $departmentsSideBar = Department::where('active',TRUE)->get();
         $subareasSideBar = Subarea::where('active',TRUE)->get();
         $rolesSideBar = Role::all();
         $subareas = Subarea::where('idDepartment',$activity->subarea->department->idDepartment)->where('active',TRUE)->get();
         $priorities = Priority::all();
         return view('management.activity.edit',['departmentsSideBar'=>$departmentsSideBar,'subareasSideBar'=>$subareasSideBar,'rolesSideBar'=>$rolesSideBar,'subarea'=>$subarea,'activity'=>$activity,'subareas'=>$subareas,'priorities'=>$priorities]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subarea $subarea, Activity $activity)
    {
        //
        $activity->activityName = $request->activityName;
        $activity->idPriority = (int)$request->idPriority;
        $activity->idSubarea = (int)$request->idSubarea;
        $activity->activityDescription  = $request->activityDescription;
        $activity->days = $request->days;
        $activity->update();
        if(auth()->user()->isAdministrator()){
            return redirect()->route('administrator.activity.index',['subarea'=>$subarea]);
        }
        else{
            return redirect()->route('coordinator.activity.index',['subarea'=>$subarea]);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subarea $subarea, Activity $activity)
    {
        //
        if($activity->active){
            $activity->active = FALSE;
            $activity->update();
            if(auth()->user()->isAdministrator()){
                return redirect()->route('administrator.activity.index',['subarea'=>$subarea]);
            }
            else{
                return redirect()->route('coordinator.activity.index',['subarea'=>$subarea]);
            }
        }
        else{
            $activity->active = TRUE;
            $activity->update();
            return redirect()->route('administrator.activity.index',['subarea'=>$subarea]);
        }
    }

  

}
