<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Department;
use App\Models\Subarea;
use App\Models\Role;
use Illuminate\Http\Request;

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
        $departmentsSideBar = Department::all();
        $rolesSideBar = Role::all();
        $subareasSideBar = Subarea::all();
        $activities = Activity::where('idSubarea',$subarea->idSubarea)->paginate(3);
        return view('management.activity.index',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'activities'=>$activities,'subarea'=>$subarea]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Subarea $subarea, Request $request)
    {
        //
        $activity = new Activity();
        $activity->activityName = $request->activityName;
        $activity->idSubarea =  $subarea->idSubarea;
        $activity->save();
        return redirect()->route('administrator.activity.index',['subarea'=>$subarea]);
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
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Subarea $subarea, Activity $activity)
    {
        //
        $departmentsSideBar = Department::all();
        $rolesSideBar = Role::all();
        $subareasSideBar = Subarea::all();
        return view('management.activity.edit',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subarea'=>$subarea,'activity'=>$activity]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        //
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
        $activity->update();
        return redirect()->route('administrator.activity.index',['subarea'=>$subarea]);
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
        Activity::destroy($activity->idActivity);
        return redirect()->route('administrator.activity.index',['subarea'=>$subarea]);
    }
}
