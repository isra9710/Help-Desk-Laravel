<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subarea;
use App\Models\Department;
use App\Models\Role;
use App\Models\Ticket;
use App\Models\Activity;
use App\Models\Poll;

class ChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexDepartment()
    {
        //
        //return "Hola";
        return view('dashboard.index');
    }
    public function indexSubarea(Department $department)
    {
        //
        //return "Hola";
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        $subareas = Subarea::where('idDepartment',$department->idDepartment)->get();
        return view('dashboard.indexSubarea',['departmentsSideBar'=>$departmentsSideBar, 'rolesSideBar'=>$rolesSideBar, 'subareasSideBar'=>$subareasSideBar,'subareas'=>$subareas]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexTechnician(Department $department)
    {
        //
        //return "Hola";
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        $agents = User::where('idDepartment',$department->idDepartment)->where('idRole',4)->get();
        return view('dashboard.indexTechnician',['departmentsSideBar'=>$departmentsSideBar, 'rolesSideBar'=>$rolesSideBar, 'subareasSideBar'=>$subareasSideBar,'agents'=>$agents]);
        //return view('dashboard.indexTechnician');
    }
    //Para los reportes
    public function ticketAgent(Request $request){
        $status='success';
        $content='';
        //if($request->idTechnician){
            $nameActivity ="No se ha podido encontrar";
            $averageScore = 0;
           //tickets vencidos
           $defeatedtickets=Ticket::where('idTechnician',$request->idTechnician)->where('idStatus',6)->get();
           //tickets que se están atendiendo
           $attendingTickets=Ticket::where('idTechnician',$request->idTechnician)->where('idStatus',2)->get();
           //Tickets cerrados
           $closedTickets = Ticket::where('idTechnician',$request->idTechnician)->where('idStatus',4)->get();
           //Consultar el id de la actividad que más se repita en los tickets atendidos por este usuario
           $mostIdActivity= Ticket::select('idActivity')
           ->groupBy('idActivity')
           ->orderByRaw('COUNT(*) DESC')
           ->limit(1)
           ->where('idTechnician',$request->idTechnician)
           ->first();
           //Ya que se tiene el identificador de la actividad, podemos consultar el objeto entero
           $mostActivity=Activity::where('idActivity',$mostIdActivity->idActivity)->first();
           if($mostActivity){
            $nameActivity=$mostActivity->activityName;
           }
           if($closedTickets){
            foreach ($closedTickets as $closedTicket){
                $poll=Poll::where('idTicket',$closedTicket->idTicket)->first();
                $averageScore =$averageScore+$poll->score; 
            }
            if(count($closedTickets)>0){
                $averageScore = $averageScore/count($closedTickets);
            }
            else{
                $averageScore="No se han contestado encuestas o no se han cerrado tickets";
            }
            
           }
           //Se cuenta la cantidad de tickets
           $tickets = count($defeatedtickets)+count($attendingTickets)+count($closedTickets);
           $user = User::where('idUser',$request->idTechnician)->first();
           $data = array(
            0=>count($attendingTickets),
            1=>count($closedTickets),
            2=>count($defeatedtickets),
            3=>$tickets,
            4=>$averageScore,
            5=>$nameActivity,
            6=>$user->name
           );
           $departmentsSideBar = Department::where('active',TRUE)->get();
           $subareasSideBar = Subarea::where('active',TRUE)->get();
           $rolesSideBar = Role::all();
           //return redirect()->back()->with();
           /*return response(json_encode($data),200)
           ->header('Content-type','text/plain');*/
           //return "Hola";
           return view('dashboard.technicianChart',['departmentsSideBar'=>$departmentsSideBar, 'rolesSideBar'=>$rolesSideBar, 'subareasSideBar'=>$subareasSideBar,'data'=>$data]);
        
       
    }

    public function ticketSubarea(Request $request){
        $nameActivity ="No se ha podido encontrar";
        $averageScore = 0;
       //tickets vencidos
        $activities = Activity::where('idSubarea',$request->idSubarea)->get();
        $idActivities = array();
        $defeatedtickets = "";
        $attendingTickets = "";
        $closedTickets = "";

        $i=0;
        foreach($activities as $activity){
        $idActivities[$i]=$activity->idActivity;
        $i=$i+1;
        }
        $i=0;
        foreach($idActivities as $idActivitie){
            if($i==0){
                $defeatedtickets = Ticket::where('idActivity',$idActivitie)
                ->where('idStatus',6)
                ->get();
                $attendingTickets = Ticket::where('idActivity',$idActivitie)
                ->where('idStatus',2)
                ->get();
                $closedTickets = Ticket::where('idActivity',$idActivitie)
                ->where('idStatus',4)
                ->get();
            }
            else{
                $newDefeatedTickets=Ticket::where('idActivity',$idActivitie)
                ->where('idStatus',6)
                ->get();
                $defeatedtickets =$defeatedtickets->merge($newDefeatedTickets);
                $newAttendingTickets=Ticket::where('idActivity',$idActivitie)
                ->where('idStatus',2)
                ->get();
                $attendingTickets = $attendingTickets->merge($newAttendingTickets);
                $newClosedTickets =Ticket::where('idActivity',$idActivitie)
                ->where('idStatus',4)
                ->get();
                $closedTickets = $closedTickets->merge($newClosedTickets);
            }
            $i=$i+1;
        }
        //Consultar el id de la actividad que más se repita en los tickets atendidos por este usuario
        /*$mostIdActivity= Ticket::select('idActivity')
        ->groupBy('idActivity')
        ->orderByRaw('COUNT(*) DESC')
        ->limit(1)
        ->where('idTechnician',$request->idTechnician)
        ->first();*/
        //Ya que se tiene el identificador de la actividad, podemos consultar el objeto entero
        //$mostActivity=Activity::where('idActivity',$mostIdActivity->idActivity)->first();
        //if($mostActivity){
        //$nameActivity=$mostActivity->activityName;
        //}
        //else{
        $nameActivity="Histoclin";
        //}
        if($closedTickets){
        foreach ($closedTickets as $closedTicket){
            $poll=Poll::where('idTicket',$closedTicket->idTicket)->first();
            $averageScore =$averageScore+$poll->score; 
        }
        if(count($closedTickets)>0){
            $averageScore = $averageScore/count($closedTickets);
        }
        else{
            $averageScore="No se han contestado encuestas o no se han cerrado tickets";
        }
        
        }
        //Se cuenta la cantidad de tickets
        $tickets = count($defeatedtickets)+count($attendingTickets)+count($closedTickets);
        $subarea= Subarea::where('idSubarea',$request->idSubarea)->first();
        $data = array(
        0=>count($attendingTickets),
        1=>count($closedTickets),
        2=>count($defeatedtickets),
        3=>$tickets,
        4=>$averageScore,
        5=>$nameActivity,
        6=>$subarea->subareaName
        );
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        return view('dashboard.subareaChart',['departmentsSideBar'=>$departmentsSideBar, 'rolesSideBar'=>$rolesSideBar, 'subareasSideBar'=>$subareasSideBar,'data'=>$data]);

    }
    public function ticketDepartment(Request $request){

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
