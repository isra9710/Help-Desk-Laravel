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
                $query->where('idStatus', '=',3)->orWhere('idStatus', '=',4)->orWhere('idStatus', '=',6);})
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
                                    ->select('tickets.*')
                                    ->where('users.idUser',$user->idUser)->where('idTechnician',NULL)->distinct()->paginate(1);
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
            /*$fileName = $file->getClientOriginalName();
            $fileName = time().'.'.$fileName;
            $path = $file->storeAs('public',$fileName);
            $dataFile->directoryFile= $path;
            $dataFile->update();*/
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
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $Ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        return view('management.ticket.editTicket',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'ticket'=>$ticket]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
        $ticket->description = $request->description;
        $ticket->update();
        return redirect()->route('administrator.ticket.inbox',['department'=>$ticket->activity->subarea->department]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $Ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $Ticket)
    {
        //
        $ticket->idStatus=3;
        $ticket->update();
    }
}
