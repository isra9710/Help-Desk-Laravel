<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Activity;
use App\Models\Subarea;
use App\Models\Department;
use App\Models\Assignment;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
               
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
        $activities = Activity::where('idSubarea',$subarea)->get();
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



    public function storeAgent(Activity $activity=NULL, Request $request)
    {
        $assignment = new Assignment();
        $assignment->idActivity = $activity->idActivity;
        $assignment->idUser = $request->idAgent;
        $assignment->temporary=FALSE;
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



    public function temporary(User $user, $option){
        $status = 'success';//Estado por defecto de mensajes 
        $content = 'Escoge a uno o más agentes para cubrir a '.$user->name;//Contenido del mensaje por defecto
        if($option==1){
            try{
                $user->status=FALSE;
                $departmentsSideBar = Department::where('active',TRUE)->get();
                $subareasSideBar = Subarea::where('active',TRUE)->get();
                $rolesSideBar = Role::all();
                Assignment::where('temporary',TRUE)->where('idUser',$user->idUser)->delete();
                $subarea=Assignment::where('idUser',$user->idUser)->first();
                $assignments = Assignment::where('idUser',$user->idUser)->get();
                $assignments1=Assignment::where('idUser',$user->idUser)->paginate(3);
                $temporaryAssignments = Assignment::join('activities', 'activities.idActivity', '=', '');
                $agents = User::where('idUser','!=',$user->idUser)->where('idDepartment',$user->idDepartment)->where('idRole',4)->get();
                $user->update();
                return view ('management.assignment.temporaryAssignment',['departmentsSideBar'=>$departmentsSideBar, 'rolesSideBar'=>$rolesSideBar, 'subareasSideBar'=>$subareasSideBar,'assignments'=>$assignments,'agents'=>$agents,'user'=>$user,'assignments1'=>$assignments1,'option'=>$option])
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
                
            }
            catch(\Throwable $th){
                DB::rollBack();
                $status = 'error';
                $content= 'Error al intentar actualizar usuario';
                return redirect()
                ->back()
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
        }
        else{
            try{
                $content= 'El usuario está de regreso';
                $user->status=TRUE;
                $user->update();
            }
            catch(\Throwable $th){
                DB::rollBack();
                $status = 'error';
                $content= 'Error al intentar actualizar usuario';
            }
            return redirect()
            ->back()
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
        
    }
        
        
       
    

    public function temporaryAssignmentAll(User $agent,$option ,Request $request){
        $status = 'success';//Estado por defecto de mensajes 
        $content = 'Se asignó subárea de manera temporal con éxito';//Contenido del mensaje por defecto
        $error= 0;
        $nameUser = User::where('idUser',$request->idAgent)->first();
        $replaceAssignments = Assignment::where('idUser',$agent->idUser)->get();
        foreach($replaceAssignments as $assignment){
            try{    
                $newAssignment = new Assignment();
                $newAssignment->idActivity=$assignment->idActivity;
                $newAssignment->idUser = $request->idAgent;
                $newAssignment->temporary=TRUE;
                $try = Assignment::where('idActivity',$assignment->idActivity)
                ->where('idUser',$request->idAgent)->first();
                if($try){
                    $error=$error+1;
                }
                else{
                    $newAssignment->save();
                }
            }
            catch(\Throwable $th){
                DB::rollBack();
                
                $status = 'error';
                $content= 'Error al asignar subarea ';
            }
        }
        if($error==count($replaceAssignments)){
            $status ='error';
            $content ='La subárea ya se encontraba asignada a '.$nameUser->name;    
        }
        else{
            if($error>=1){
                $status ='warning';
                $content ='Algunas actividades ya se encontraban asignadas a '.$nameUser->name;
            }
        }
        
        if(auth()->user()->isAdministrator()){
            return redirect()
            ->route('administrator.user.status',['user'=>$agent,'option'=>$option])
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
        else{
            return redirect()
            ->route('assistant.user.status',['user'=>$agent,'option'=>$option])
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
    
    }

    public function temporaryAssignment(User $agent,$option ,Request $request){
        $status = 'success';//Estado por defecto de mensajes 
        $content = 'Se asignó subárea de manera temporal con éxito';//Contenido del mensaje por defecto
        $nameUser = User::where('idUser',$request->idAgent)->first();
        $try = Assignment::where('idUser',$request->idAgent)->where('idActivity',$request->idActivity)->first();
        if($try){
            $status = 'error';
            $content='Esa actividad ya se encuentra asignada a '.$nameUser->name;
        }
        else{
            try{    
                $assignment = new Assignment();
                $assignment->idActivity = $request->idActivity;
                $assignment->idUser = $request->idAgent;
                $assignment->temporary=TRUE;
                $assignment->save();
            }
            catch(\Throwable $th){
                DB::rollBack();
                
                $status = 'error';
                $content= 'Error al asignar actividad';
            }
        }        
        
    
        if(auth()->user()->isAdministrator()){
            return redirect()
            ->route('administrator.user.status',['user'=>$agent])
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
        else{
            return redirect()
            ->route('assistant.user.status',['user'=>$agent])
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
            
        
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
