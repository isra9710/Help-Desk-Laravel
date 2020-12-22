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
   
    public function indexSubarea(Department $department)
    {
        //
       
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
      
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        $agents = User::where('idDepartment',$department->idDepartment)->where('idRole',4)->get();
        return view('dashboard.indexTechnician',['departmentsSideBar'=>$departmentsSideBar, 'rolesSideBar'=>$rolesSideBar, 'subareasSideBar'=>$subareasSideBar,'agents'=>$agents]);
       
    }
    //Para los reportes
    public function ticketAgent(Request $request){
        $status='success';
        $content='';
        if($request->idTechnician){
            $nameActivity ="No se ha podido encontrar";
            $averageScore = 0;
           //tickets vencidos
           $defeatedTickets=Ticket::where('idTechnician',$request->idTechnician)->where('idStatus',6)->get();
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
           if($mostIdActivity){
            //Ya que se tiene el identificador de la actividad, podemos consultar el objeto entero
            $mostActivity=Activity::where('idActivity',$mostIdActivity->idActivity)->first();
            if($mostActivity){
             $nameActivity=$mostActivity->activityName;
            }
            else{
                $nameActivity="No se han registrado suficientes tickets para determinar ésto";
                }    
            }
            else{
            $nameActivity="No se han registrado suficientes tickets para determinar ésto";
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

     
            $tickets = count($defeatedTickets)+count($attendingTickets)+count($closedTickets);
            $user = User::where('idUser',$request->idTechnician)->first();
            $data = array(
                0=>count($attendingTickets),
                1=>count($closedTickets),
                2=>count($defeatedTickets),
                3=>$tickets,
                4=>$averageScore,
                5=>$nameActivity,
                6=>$user->name
            );
            $departmentsSideBar = Department::where('active',TRUE)->get();
            $subareasSideBar = Subarea::where('active',TRUE)->get();
            $rolesSideBar = Role::all();
          
            return view('dashboard.technicianChart',['departmentsSideBar'=>$departmentsSideBar, 'rolesSideBar'=>$rolesSideBar, 'subareasSideBar'=>$subareasSideBar,'data'=>$data]);
        }
        else{
            $status = 'error';
            $content= 'Error, elige un técnico';
            return redirect()->back()->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
       
    }

    public function ticketSubarea(Request $request){
        
        if($request->idSubarea){
            $nameActivity ="No se ha podido encontrar";
            $averageScore = 0;
        //tickets vencidos
            $activities = Activity::where('idSubarea',$request->idSubarea)->get();
            $idActivities = array();
            $openTickets = "";
            $attendingTickets = "";
            $cancelTickets = "";
            $closedTickets = "";
            $closedOpenedTickets="";
            $defeatedTickets = "";
            $defeatedOpenedTickets="";
            $i=0;
            foreach($activities as $activity){
            $idActivities[$i]=$activity->idActivity;
            $i=$i+1;
            }
            $i=0;
            foreach($idActivities as $idActivitie){
                if($i==0){
                    $openTickets = Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',1)
                    ->get();
                    $attendingTickets = Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',2)
                    ->get();
                    
                    $cancelTickets  = Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',3)
                    ->get();
                    $closedTickets = Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',4)
                    ->get();
                    $closedOpenedTickets = Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',5)
                    ->get();
                    $defeatedTickets=Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',6)
                    ->get();
                    $defeatedOpenedTickets = Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',7)
                    ->get();
                    
                    
                }
                else{
                    $newOpenTickets = Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',1)
                    ->get();
                    $openTickets = $openTickets->merge($newOpenTickets);
                    
                    $newAttendingTickets=Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',2)
                    ->get();
                    $attendingTickets = $attendingTickets->merge($newAttendingTickets);

                    $newCancelTickets = Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',3)
                    ->get();
                    $cancelTickets = $cancelTickets->merge($newCancelTickets);
                    
                    $newClosedTickets =Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',4)
                    ->get();
                    $closedTickets = $closedTickets->merge($newClosedTickets);


                    $newClosedOpenedTickets = Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',5)
                    ->get();
                    $closedOpenedTickets = $closedOpenedTickets->merge($newClosedOpenedTickets);


                    $newDefeatedTickets=Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',6)
                    ->get();
                    $defeatedTickets =$defeatedTickets->merge($newDefeatedTickets);

                    $newDefeatedOpenedTickets = Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',7)
                    ->get();
                    $defeatedOpenedTickets = $defeatedOpenedTickets->merge($newDefeatedOpenedTickets);
                    
                    
                }
                $i=$i+1;
            }
            
            //Consultar el id de la actividad que más se repita en los tickets atendidos por este usuario
            $mostIdActivity=Ticket::join('activities','tickets.idActivity', '=', 'activities.idActivity')
            ->join('subareas','activities.idSubarea', '=', 'subareas.idSubarea')
            ->where('subareas.idSubarea',$request->idSubarea)
            ->select('tickets.idActivity')
            ->groupBy('tickets.idActivity')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->first();
            if($mostIdActivity){
                //Ya que se tiene el identificador de la actividad, podemos consultar el objeto entero
                $mostActivity=Activity::where('idActivity',$mostIdActivity->idActivity)->first();
                if($mostActivity){
                $nameActivity=$mostActivity->activityName;
                }
                else{
                    $nameActivity="No se han registrado suficientes tickets para determinar ésto";
                    }    
            }
            else{
            $nameActivity="No se han registrado suficientes tickets para determinar ésto";
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
            if($openTickets == ""){
                $numberOpenTickets =0;
            }
            else{
                $numberOpenTickets =count($openTickets);
            }
            if($attendingTickets == ""){
                $numberAttendingTickets =0;
            }
            else{
                $numberAttendingTickets = count($attendingTickets);
            }
            if($cancelTickets==""){
                $numberCancelTickets = 0;
            }else{
                $numberCancelTickets= count($cancelTickets);
            }
            if($closedTickets==""){
                $numberClosedTickets = 0;
            }else{
               $numberClosedTickets= count($closedTickets);
            }
            if($closedOpenedTickets==""){
                $numberClosedOpenedTickets = 0;
            }else{
                $numberClosedOpenedTickets = count($closedOpenedTickets);
            }
            if($defeatedTickets==""){
                $numberDefeatedTickets =0;
            }else{
                $numberDefeatedTickets = count($defeatedTickets);
            }
            if($defeatedOpenedTickets==""){
                $numberDefeatedOpenedTickets = 0;
            }else{
                $numberDefeatedOpenedTickets = count($defeatedOpenedTickets);
            }
            $tickets =$numberOpenTickets
            +$numberAttendingTickets
            +$numberCancelTickets
            +$numberClosedTickets
            +$numberClosedOpenedTickets
            +$numberDefeatedTickets
            +$numberDefeatedOpenedTickets;
            $subarea= Subarea::where('idSubarea',$request->idSubarea)->first();
            $data = array(
            0=>$numberOpenTickets,
            1=>$numberAttendingTickets,
            2=>$numberCancelTickets,
            3=>$numberClosedTickets,
            4=>$numberClosedOpenedTickets,
            5=>$numberDefeatedTickets,
            6=>$numberDefeatedOpenedTickets,
            7=>$tickets,
            8=>$averageScore,
            9=>$nameActivity,
            10=>$subarea->subareaName
            );
            $departmentsSideBar = Department::where('active',TRUE)->get();
            $subareasSideBar = Subarea::where('active',TRUE)->get();
            $rolesSideBar = Role::all();
          
            return view('dashboard.subareaChart',['departmentsSideBar'=>$departmentsSideBar, 'rolesSideBar'=>$rolesSideBar, 'subareasSideBar'=>$subareasSideBar,'data'=>$data]);
        }
        else{
            $status = 'error';
            $content= 'Error, elige una subárea';
            return redirect()->back()->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
        }
    }





    public function ticketDepartment(Department $department){
       
        $nameActivity ="No se ha podido encontrar";
         $averageScore = 0;
        //tickets vencidos
        $subareas = Subarea::where('idDepartment',$department->idDepartment)->get();
        $activities = "";
        $j=0;
        foreach($subareas as $subarea){
            if($j==0){
                $activities = Activity::where('idSubarea',$subarea->idSubarea)->get();    
            }
            else{
                $newActivity = Activity::where('idSubarea',$subarea->idSubarea)->get();
            $activities = $activities->merge($newActivity);
            }
            $j=$j+1;
        }
            $idActivities = array();
            $openTickets = "";
            $attendingTickets = "";
            $cancelTickets = "";
            $closedTickets = "";
            $closedOpenedTickets="";
            $defeatedTickets = "";
            $defeatedOpenedTickets="";
            $i=0;
            foreach($activities as $activity){
            $idActivities[$i]=$activity->idActivity;
            $i=$i+1;
            }
            $i=0;
            foreach($idActivities as $idActivitie){
                if($i==0){
                    $openTickets = Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',1)
                    ->get();

                    $attendingTickets = Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',2)
                    ->get();
                    
                    $cancelTickets  = Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',3)
                    ->get();

                    $closedTickets = Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',4)
                    ->get();

                    $closedOpenedTickets = Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',5)
                    ->get();

                    $defeatedTickets = Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',6)
                    ->get();
                    
                    $defeatedOpenedTickets = Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',7)
                    ->get();
                }
                else{
                    $newOpenTickets = Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',1)
                    ->get();
                    $openTickets = $openTickets->merge($newOpenTickets);
                    
                    $newAttendingTickets=Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',2)
                    ->get();
                    $attendingTickets = $attendingTickets->merge($newAttendingTickets);

                    $newCancelTickets = Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',3)
                    ->get();
                    $cancelTickets = $cancelTickets->merge($newCancelTickets);
                    
                    $newClosedTickets =Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',4)
                    ->get();
                    $closedTickets = $closedTickets->merge($newClosedTickets);


                    $newClosedOpenedTickets = Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',5)
                    ->get();
                    $closedOpenedTickets = $closedOpenedTickets->merge($newClosedOpenedTickets);


                    $newDefeatedTickets=Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',6)
                    ->get();
                    
                    $defeatedTickets =$defeatedTickets->merge($newDefeatedTickets);

                    $newDefeatedOpenedTickets = Ticket::where('idActivity',$idActivitie)
                    ->where('idStatus',7)
                    ->get();
                    $defeatedOpenedTickets = $defeatedOpenedTickets->merge($newDefeatedOpenedTickets);
                    
                    
                }
                $i=$i+1;
            }
           
            //Consultar el id de la actividad que más se repita en los tickets atendidos por este usuario
            $mostIdActivity=Ticket::join('activities','tickets.idActivity', '=', 'activities.idActivity')
            ->join('subareas','activities.idSubarea', '=', 'subareas.idSubarea')
            ->join('departments', 'subareas.idDepartment', '=', 'departments.idDepartment')
            ->where('departments.idDepartment',$department->idDepartment)
            ->select('tickets.idActivity')
            ->groupBy('tickets.idActivity')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->first();
            if($mostIdActivity){
                //Ya que se tiene el identificador de la actividad, podemos consultar el objeto entero
                $mostActivity=Activity::where('idActivity',$mostIdActivity->idActivity)->first();
                if($mostActivity){
                $nameActivity=$mostActivity->activityName;
                }
                else{
                    $nameActivity="No se han registrado suficientes tickets para determinar ésto";
                    }    
            }
            else{
            $nameActivity="No se han registrado suficientes tickets para determinar ésto";
            }
            if($closedTickets){
            foreach ($closedTickets as $closedTicket){
                $poll=Poll::where('idTicket',$closedTicket->idTicket)->first();
                $averageScore =$averageScore+$poll->score; 
                }
            }

            if(count($closedTickets)>0){
                $averageScore = $averageScore/count($closedTickets);
            }
            else{
                $averageScore="No se han contestado encuestas o no se han cerrado tickets";
            }
            
            
        
        //Se cuenta la cantidad de tickets
        if($openTickets == ""){
         
          
            $numberOpenTickets =0;
        }
        else{
          
            $numberOpenTickets =count($openTickets);
        }
        if($attendingTickets == ""){
           
            $numberAttendingTickets =0;
        }
        else{
            $numberAttendingTickets = count($attendingTickets);
        }
        if($cancelTickets==""){
           
            $numberCancelTickets = 0;
        }else{
            $numberCancelTickets= count($cancelTickets);
        }
        if($closedTickets==""){
          
            $numberClosedTickets = 0;
        }else{
           $numberClosedTickets= count($closedTickets);
        }
        if($closedOpenedTickets==""){
          
            $numberClosedOpenedTickets = 0;
        }else{
            $numberClosedOpenedTickets = count($closedOpenedTickets);
        }
        if($defeatedTickets===""){
           
            $numberDefeatedTickets =0;
        }else{
            $numberDefeatedTickets = count($defeatedTickets);
        }
        if($defeatedOpenedTickets==""){
           
            $numberDefeatedOpenedTickets = 0;
        }else{
            $numberDefeatedOpenedTickets = count($defeatedOpenedTickets);
        }
        $tickets =$numberOpenTickets
        +$numberAttendingTickets
        +$numberCancelTickets
        +$numberClosedTickets
        +$numberClosedOpenedTickets
        +$numberDefeatedTickets
        +$numberDefeatedOpenedTickets;
            $department= Department::where('idDepartment',$department->idDepartment)->first();
            $data = array(
            0=>$numberOpenTickets,
            1=>$numberAttendingTickets,
            2=>$numberCancelTickets,
            3=>$numberClosedTickets,
            4=>$numberClosedOpenedTickets,
            5=>$numberDefeatedTickets,
            6=>$numberDefeatedOpenedTickets,
            7=>$tickets,
            8=>$averageScore,
            9=>$nameActivity,
            10=>$department->departmentName
            );
            $departmentsSideBar = Department::where('active',TRUE)->get();
            $subareasSideBar = Subarea::where('active',TRUE)->get();
            $rolesSideBar = Role::all();
          
            return view('dashboard.departmentChart',['departmentsSideBar'=>$departmentsSideBar, 'rolesSideBar'=>$rolesSideBar, 'subareasSideBar'=>$subareasSideBar,'data'=>$data]);
       
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
