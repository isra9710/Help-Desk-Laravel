<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Activity;
use App\Models\Subarea;
use App\Models\Department;
use App\Models\Assignment;
use App\Models\Role;
               
class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user=NULL, Activity $activity=NULL)
    {
        //
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        if($user){//Si se quiere saber las actividades a las que está ligado un técnico
            $userActivities =Assignment::where('idUser',$user->idUser)->paginate(3);//Actividades a las que está ligado el técnico
            //La siguiente consulta es para las actividades ligadas al departamento
            $activities = Activity::join('subareas','activities.idSubarea', '=', 'subareas.idSubarea')
            ->join('departments', 'subareas.idDepartment', '=', 'departments.idDepartment')
            ->where('departments.idDepartment',$user->idDepartment)->get();
            return view('management.assignment.indexUser',['departmentsSideBar'=>$departmentsSideBar, 'rolesSideBar'=>$rolesSideBar, 'subareasSideBar'=>$subareasSideBar,'userActivities'=>$userActivities,'activities'=>$activities,'user'=>$user]);
        }
        else{//De otro modo se desea consultar los agentes ligados a cierta actividad
            $assignments=Assignment::where('idActivity',$activity->idActivity)->paginate(3);
            //$assignments = User::join('assignments','users.idUser','=','assignments.idUser')
            //->join('activities','assignments.idActivity', '=' ,'activities.idActivity')
            //->select('users.*')->where('activities.idActivity',$activity->idActivity)->get();
            //Los agentes del departamento
            $agents=User::where('idDepartment',$activity->subarea->department->idDepartment)->where('idRole',4)->get();
            return view('management.assignment.indexAssignment',['departmentsSideBar'=>$departmentsSideBar, 'rolesSideBar'=>$rolesSideBar, 'subareasSideBar'=>$subareasSideBar,'assignments'=>$assignments,'agents'=>$agents,'activity'=>$activity]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user=NULL,Subarea $subarea=NULL, $temporary=NULL,Request $request)  {
        //
        $activities = Activity::where('idSubarea',$idSubarea)->get();
        foreach($activities as $activity){
            $assignment = new Assignment();
            $assignment->idActivity=$activity->idActivity;
            $assignment->idUser=$user->idUser;
            if($temporary){
                $assignment->temporary=TRUE;
            }
            else{
                $assignment->temporary=FALSE;
            }
            $assignment->save();
        }   
    
    }



    public function storeAgent(Activity $activity,$temporary=NULL, Request $request)
    {
        $assignment = new Assignment();
        $assignment->idActivity = $activity->idActivity;
        $assignment->idUser = $request->idAgent;
        if($temporary){
            $assignment->temporary=TRUE;
        }
        else{
            $assignment->temporary=FALSE;
        }
        $assignment->save();
        
        return redirect()->route('administrator.assignment.activity',['activity'=>$activity]);
    }



    public function storeActivity(User $user, $temporary=NULL,Request $request){
        $assignment = new Assignment();
        $assignment->idUser = $user->idUser;
        $assignment->idActivity = $request->idActivity;
        if($temporary){
                $assignment->temporary=TRUE;
            }
        else{
                $assignment->temporary=FALSE;
            }
        $assignment->save();
        return redirect()->route('administrator.assignment.user',['user'=>$user]);
    }



    public function temporary(User $user){
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        Assignment::where('temporary',TRUE)->where('idUser',$user->idUser)->delete();
        $subarea=Assignment::where('idUser',$user->idUser)->first();
        $subarea = $subarea->activity->subarea;
        $assignments = Assignment::where('idUser',$user->idUser)->paginate(3);
        $temporaryAssignments = Assignment::join('activities', 'activities.idActivity', '=', '');
        $agents = User::where('idUser','!=',$user->idUser)->where('idDepartment',$user->idDepartment)->where('idRole',4)->get();
        return view ('management.assignment.temporaryAssignment',['departmentsSideBar'=>$departmentsSideBar, 'rolesSideBar'=>$rolesSideBar, 'subareasSideBar'=>$subareasSideBar,'assignments'=>$assignments,'subarea'=>$subarea,'agents'=>$agents]);
        
        //public function index($idRole=null, $idDepartment=null)
    }


    public function temporaryAssignment(Subarea $subarea=null,Request $request){

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user=NULL, Activity $activity=NULL)
    {
        //
        $assignments = Assignment::where('idUser',$user->idUser);
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        return view('management.assignment.index',['departmentsSideBar'=>$departmentsSideBar, 'rolesSideBar'=>$rolesSideBar, 'subareasSideBar'=>$subareasSideBar,'assignmenets'=>$assignments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignment $assignment, User $user=NULL, Activity $activity=NULL)
    {
        //
        $assignment->destroy($assignment->idAssignment);
        if($user){
            return redirect()->route('administrator.assignment.user',['user'=>$user]);
        }
        else{
            return redirect()->route('administrator.assignment.activity',['activity'=>$activity]);
        }
    }
}
