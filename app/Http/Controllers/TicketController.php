<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Activity;
use App\Models\Subarea;
use App\Models\Department;
use App\Models\User;
use App\Models\Role;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *boolean $noAsignados
     * @return \Illuminate\Http\Response
     */
    public function historical(Department $department){
        //
        $subareasSideBar = Subarea::all();
        $departmentsSideBar = Department::all();
        $rolesSideBar = Role::all();
        $tickets = "";
    
        $tickets=Ticket::join('activities','tickets.idActivity', '=', 'activities.idActivity')
            ->join('subareas','activities.idSubarea', '=', 'subareas.idSubarea')
            ->join('departments', 'subareas.idDepartment', '=', 'departments.idDepartment')
            ->select('tickets.*')->where('departments.idDepartment',$department->idDepartment)->where('tickets.startDate','<',Carbon::now()->subDays(30))
            ->where(function($query){
                $query->orWhere('idStatus', '=',4)->orWhere('idStatus', '=',6);})
            ->orWhere('idStatus','=',3)
            ->paginate(15);
            
               
       
        $fechaActual = new \DateTime();
        //dd($fechaActual->format('d-m-Y'));
        return view ('management.ticket.historicalTickets',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'department'=>$department,'tickets'=>$tickets]);
    }






    /**
     * Display a listing of the resource.
     *boolean $noAsignados
     * @return \Illuminate\Http\Response
     */
    public function inbox(Department $department=null){
        //
        $subareasSideBar = Subarea::all();
        $departmentsSideBar = Department::all();
        $rolesSideBar = Role::all();
        $tickets = "";
       /*Se hace un join para saber todos los tickets    
        en éstos se muestran los tickets abiertos,
        reabiertos,
        cerrados(con menos de 1 mes de antigüedad),
        vencidos(con menos de 1 mes de antigüedad), cancelados.
        */
        $tickets=Ticket::join('activities','tickets.idActivity', '=', 'activities.idActivity')
        ->join('subareas','activities.idSubarea', '=', 'subareas.idSubarea')
        ->join('departments', 'subareas.idDepartment', '=', 'departments.idDepartment')
        ->select('tickets.*')->where('departments.idDepartment',$department->idDepartment)->where('tickets.startDate','>',Carbon::now()->subDays(30))
        ->where(function($query){
            $query->orWhere('idStatus', '=',1)->orWhere('idStatus', '=',2)->orWhere('idStatus', '=',4)->orWhere('idStatus', '=',5)->orWhere('idStatus', '=',6)->orWhere('idStatus', '=',7);;

        })->paginate(15);
        return view ('management.ticket.inboxTickets',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'department'=>$department,'tickets'=>$tickets]);
    }











    /**
     * Display a listing of the resource.
     *boolean $noAsignados
     * @return \Illuminate\Http\Response
     */
    public function notAssigned(Department $department) {
        //
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        $tickets=Ticket::join('activities','tickets.idActivity', '=', 'activities.idActivity')
                ->join('subareas','activities.idSubarea', '=', 'subareas.idSubarea')
                ->join('departments', 'subareas.idDepartment', '=', 'departments.idDepartment')
                ->select('tickets.*')->where('departments.idDepartment',$department->idDepartment)->where('doubt',TRUE)
                ->where(function($query){
                    $query->orWhere('idStatus', '=',1)->orWhere('idStatus', '=',2)->orWhere('idStatus', '=',5)->orWhere('idStatus', '=',7);
                })
                ->paginate(15);     
        return view ('management.ticket.notAssignedTickets',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'department'=>$department,'tickets'=>$tickets]);
    }

    //Los tickets que el usuario ha levantado
    public function myTickets($employeNumber){
        $myTickets = Ticket::where('employeeNumber',$employeNumber)->paginate(3);
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        return view ('management.ticket.myTickets',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'tickets'=>$myTickets]);
    }

    //Los tickets en los que un agente puede intervenir
    public function ticketsForAttend(User $user) {
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        $ticketsForAttend = Ticket::join('assignments','tickets.idActivity','=', 'assignments.idActivity')
                                    ->join('users','assignments.idUser', '=','users.idUser')
                                    ->where(function($query){
                                        $query->Where('tickets.idTechnician',NULL)->Where('tickets.idStatus','!=',3)->Where('tickets.idStatus','!=',4)->orWhere(function($query1){
                                                $query1->where('tickets.idTechnician',auth()->user()->idUser)->orWhere('tickets.idStatus',2)->Where('tickets.idStatus',4)
                                                ->orWhere(function($query2){
                                                    $query2->join('assignments','tickets.idActivity','=', 'assignments.idActivity')
                                                    ->join('users','assignments.idUser', '=','users.idUser')
                                                    ->select('tickets.*')
                                                    ->where('users.idUser',auth()->user()->idUser)->where('tickets.idTechnician',NULL)->where('assignments.temporary',TRUE);
                                        });
                                    });
                                  
                                    })
                                    ->select('tickets.*')
                                    ->distinct()
                                    ->where('users.idUser',$user->idUser)
                                   
                                    ->paginate(10);
        return view('management.ticket.ticketsForAttend',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'tickets'=>$ticketsForAttend]);
    }
    /*Cuando un agente levanta la mano, se actualiza el campo "idTechinician" de
        tickets por el agente que acaba de levantar la mano 
    */
    public function ticketsTechnician(User $user, Ticket $ticket){
        $ticket->idTechnician=$user->idUser;
        $ticket->idStatus = 2;
        $ticket->update();
        return redirect()->route('agent.ticket.attend',['user'=>$user]);
    }


    //Tikcets que ya está atendiendo un agente determinado
    public function ticketsAgent(User $user){
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        $ticketsAgent = Ticket::where('idTechnician',$user->idUser)->paginate(10);
        return view('management.ticket.assignedTIckets',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'tickets'=>$ticketsAgent]);
    }



    //Tickets en los que un agente puede ayudar
    public function help(User $user){
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        $ticketsForAttend = Ticket::join('assignments','tickets.idActivity','=', 'assignments.idActivity')
        ->join('users','assignments.idUser', '=','users.idUser')
        ->select('tickets.*')
        ->where('users.idUser',$user->idUser)->where('idTechnician',NULL)->where('assignments.temporary',TRUE)->distinct()->paginate(10);
        return view ('management.ticket.ticketsForAttendHelp',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'tickets'=>$ticketsForAttend]);
    }

    public function toTransfer(Ticket $ticket, $option){
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        $agents = User::where('idDepartment',$ticket->activity->subarea->department->idDepartment)->where('idRole',4)->get();
        return view('management.ticket.Totransfer',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'ticket'=>$ticket,'agents'=>$agents,'option'=>$option]);
    }
    
    public function reasign(Request $request,Ticket $ticket, $option){
        $ticket->doubt=FALSE;
        $ticket->idTechnician=$request->idTechnician;
        $ticket->update();
        if($option==1){
            if(auth()->user()->isAdministrator()){
                return redirect()->route('administrator.ticket.notAssigned',['department'=>$ticket->activity->subarea->department]);
            }
            else{
                return redirect()->route('coordinator.ticket.notAssigned',['department'=>$ticket->activity->subarea->department]);
            }
        }
        else{
            return redirect()->route('agent.ticket.attend',['user'=>auth()->user()]);
        }
    }
    /**
     * Show the form for creating a new resource.
     *@param boolean $guest
     * @return \Illuminate\Http\Response
     */
    public function create($guest=NULL)
    {
        //
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $subareas = Subarea::where('active',TRUE)->get();
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $departments = Department::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        if($guest){
            return view('management.ticket.addTicketG',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar]);
        }
        else{
            return view('management.ticket.addTicket',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar]);
        }
       
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
        $activity = Activity::where('idActivity', $request->idActivity)->first();
        $ticket = new Ticket();
        /*
        Los siguiente datos los obtenemos del formulario de registro ubicado en managment.user.index
        */
        $ticket->idStatus=1;
        $ticket->idActivity = $request->idActivity;
        $ticket->startDate = Carbon::now();
        //dd(Carbon::now()->subDays($activity->days));
        $ticket->limitDate = Carbon::now()->addDays($activity->days);
        $ticket->ticketDescription = $request->description;
        if(isset($request->doubt)){    
            $ticket->doubt= 1;
        }
        else{
            $ticket->doubt = 0;
        }
        $ticket->save();
        if($request->file){
            $dataFile = new File();
            $fileName = "";//Nombre del archivo
            $dataFile->idTicket=$ticket->idTicket;
            $dataFile->save();
            $file= $request->file('file');
            if($request->employeeNumber){
                $userName = User::Where('username',$request->employeeNumber)->first();
                $fileName =$userName.$dataFile->idFile.$request->file->getClientOriginalName();
            }
            else{
                $fileName =auth()->user()->username.$dataFile->idFile.$request->file->getClientOriginalName();
            }
            $path = $file->storeAs('public',$fileName);
            $dataFile->directoryFile = $path;
            $dataFile->update();
        }
        //Esto quiere decir que se está registrando un ticket para alguien más
        if($request->employeeNumber){
            $ticket->employeeNumber = $request->employeeNumber;
            $ticket->update();
            if(auth()->user()->isAdministrator()){
                return redirect()->route('administrator.ticket.create',['guest'=>True]);
            }
            else{
                return redirect()->route('coordinator.ticket.create',['guest'=>True]);
            }
        }
        //De otro modo el ticket es para quien está llamando la función
        else{
            $ticket->employeeNumber = auth()->user()->username;
            $ticket->update();
            if(auth()->user()->isAdministrator()){
                return redirect()->route('administrator.ticket.create');
            }
            elseif(auth()->user()->isCoordinator()){
                return redirect()->route('coordinator.ticket.create');
            }
            elseif(auth()->user()->isAssistant()){
                return redirect()->route('assistant.ticket.create');
            }
            elseif(auth()->user()->isAgent()){
                return redirect()->route('agent.ticket.create');
            }
            elseif(auth()->user()->isUser()){
                return redirect()->route('user.ticket.create');
            }
            //Cambiar la siguiente ruta por invitado
            else{
                return redirect()->route('user.ticket.create');
            }
        }
       



       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $Ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket, $option)
    {
        //
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        return view('management.ticket.showTicket',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'ticket'=>$ticket,'option'=>$option]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $Ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket,$option)
    {
        //
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        return view('management.ticket.editTicket',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'ticket'=>$ticket,'option'=>$option]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket, $option=NULL)
    {
        //
        $ticket->ticketDescription = $request->description;
        $ticket->update();
        if($option==1)
            if(auth()->user()->isAdministrator()){
                return redirect()->route('administrator.ticket.inbox',['department'=>$ticket->activity->subarea->department]);
            }
            else{
                return redirect()->route('coordinator.ticket.inbox',['department'=>$ticket->activity->subarea->department]);
            }
        else{
            if(auth()->user()->isAdministrator()){
                return redirect()->route('administrator.ticket.notAssigned',['department'=>$ticket->activity->subarea->department]);
            }
            else{
                return redirect()->route('coordinator.ticket.notAssigned',['department'=>$ticket->activity->subarea->department]);
            }
        }
    }
    public function updateMyTicket(Request $request, Ticket $ticket)
    {
        //
        $ticket->ticketDescription = $request->description;
        $ticket->update();
        return redirect()->route('administrator.ticket.inbox',['department'=>$ticket->activity->subarea->department]);
        //return back();
    }

    public function closeMyTicket(Ticket $ticket){
        
    }
    public function close(Ticket $ticket){

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $Ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket, $ticketOption, $option)
    {
        //
        if($ticketOption==1){
            if($ticket->idStatus==4){
                $ticket->idStatus=5;
                $ticket->update();
            }
            else{
                $ticket->idStatus=7;
                $ticket->update();
            }
        }
        elseif($ticketOption==2){
            $ticket->idStatus=3;
            $ticket->update();
        }
        else{
            $ticket->idStatus=4;
            $ticket->closeDate=Carbon::now();
            $ticket->update();
        }
        if($option==1){
            if(auth()->user()->isAdministrator()){
                return redirect()->route('administrator.ticket.inbox',['department'=>$ticket->activity->subarea->department]);
            }
            else{
                return redirect()->route('administrator.ticket.inbox',['department'=>$ticket->activity->subarea->department]);
            }
        }
        else{
            return redirect()->route('agent.ticket.attend',['user'=>auth()->user()]);
        }
    }

    public function destroyMyTicket(Ticket $Ticket)
    {
        //
        $ticket->idStatus=3;
        $ticket->update();
    }

}
