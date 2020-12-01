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
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    
    
    
    public function updateTickets(){
        $tickets=Ticket::where('idStatus','!=',3)
        ->where('idStatus','!=',4)
        ->Where('idStatus','!=',6)
        ->where('idStatus','!=',7)
        ->orderBy('idTicket','DESC')
        ->get();
        if($tickets){
        foreach($tickets as $ticket){
            $closeDate=Carbon::parse($ticket->limitDate);
            if($closeDate->diffInDays(Carbon::now())>$ticket->activity->days){
                $ticket->idStatus=6;
                $ticket->update();
            }
        }
    }
    }
    /**
     * Display a listing of the resource.
     *boolean $noAsignados
     * @return \Illuminate\Http\Response
     */
    public function historical(Department $department){
        //
        $this->updateTickets();
        $subareasSideBar = Subarea::all();
        $departmentsSideBar = Department::all();
        $rolesSideBar = Role::all();
        $tickets = "";
    
        $tickets=Ticket::join('activities','tickets.idActivity', '=', 'activities.idActivity')
            ->join('subareas','activities.idSubarea', '=', 'subareas.idSubarea')
            ->join('departments', 'subareas.idDepartment', '=', 'departments.idDepartment')
            ->select('tickets.*')->where('departments.idDepartment',$department->idDepartment)->where('tickets.created_at','<',Carbon::now()->subDays(30))
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
        $this->updateTickets();
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
        ->select('tickets.*')->where('departments.idDepartment',$department->idDepartment)->where('tickets.created_at','>',Carbon::now()->subDays(30))
        ->where(function($query){
            $query->orWhere('idStatus', '=',1)->orWhere('idStatus', '=',2)->orWhere('idStatus', '=',4)->orWhere('idStatus', '=',5)->orWhere('idStatus', '=',6)->orWhere('idStatus', '=',7);;

        })
        ->orderBy('idStatus','ASC')
        ->paginate(10);
        return view ('management.ticket.inboxTickets',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'department'=>$department,'tickets'=>$tickets]);
    }









    //Esta función nos retornará todos los tickets de los que se tenga duda

    /**
     * Display a listing of the resource.
     *boolean $noAsignados
     * @return \Illuminate\Http\Response
     */
    public function notAssigned(Department $department) {
        //
        $this->updateTickets();
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
        $this->updateTickets();
        $myTickets = Ticket::where('employeeNumber',$employeNumber)
        ->orderBy('idStatus','ASC')
        ->paginate(3);
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        return view ('management.ticket.myTickets',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'tickets'=>$myTickets]);
    }

    //Los tickets en los que un agente puede intervenir
    public function ticketsForAttend(User $user) {
        $this->updateTickets();
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
                                    ->orderBy('idStatus','ASC')
                                    ->paginate(10);
        return view('management.ticket.ticketsForAttend',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'tickets'=>$ticketsForAttend]);
    }
    //Rotorna la vista con los agentes del departamentos para transferir
    public function toTransfer(Ticket $ticket, $option){
        $this->updateTickets();
        $departmentsSideBar = Department::where('active',TRUE)->get();
        $subareasSideBar = Subarea::where('active',TRUE)->get();
        $rolesSideBar = Role::all();
        $agents = User::where('idDepartment',$ticket->activity->subarea->department->idDepartment)->where('idRole',4)->where('status',1)->get();
        return view('management.ticket.Totransfer',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'ticket'=>$ticket,'agents'=>$agents,'option'=>$option]);
    }
    //Muestra los agentes y se elige al nuevo
    public function reasign(Request $request,Ticket $ticket, $option){
        $this->updateTickets();
        $ticket->doubt=FALSE;
        $ticket->idTechnician=$request->idTechnician;
        $ticket->update();
        if($option==1){
            if(auth()->user()->isAdministrator()){
                return redirect()
                ->route('administrator.ticket.notAssigned',['department'=>$ticket->activity->subarea->department])
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            else{
                return redirect()
                ->route('coordinator.ticket.notAssigned',['department'=>$ticket->activity->subarea->department])
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
        }
        else{
            return redirect()
            ->route('agent.ticket.attend',['user'=>auth()->user()])
            ->with('process_result',[
                'status'=>$status,
                'content'=>$content
            ]);
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
        $this->updateTickets();
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
        $status = 'success';//Estado por defecto de mensajes 
        $content = '';//Contenido del mensaje por defecto
        $this->updateTickets();
        try{
            $activity = Activity::where('idActivity', $request->idActivity)->first();
            $ticket = new Ticket();
            /*
            Los siguiente datos los obtenemos del formulario de registro ubicado en managment.user.index
            */
            $ticket->idStatus=1;
            $ticket->idActivity = $request->idActivity;
            $ticket->limitDate = Carbon::now()->addDays($activity->days);
            $ticket->ticketDescription = $request->ticketDescription;
            if(isset($request->doubt)){    
                $ticket->doubt= 1;
            }
            else{
                $ticket->doubt = 0;
            }
            //Esto quiere decir que se está registrando un ticket para alguien más
            if($request->employeeNumber){
                $ticket->employeeNumber = $request->employeeNumber;
                
            }else{
                $ticket->employeeNumber = auth()->user()->username;
            }
            $ticket->save();
            $content = 'Se registró con éxito el ticket cuyo número de folio es '.$ticket->idTicket;
            if($request->file){
                $dataFile = new File();
                $fileName = "";//Nombre del archivo
                $dataFile->idTicket=$ticket->idTicket;
                $dataFile->fileDescription=$request->fileDescription;
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
            
    }catch(\Throwable $th){
        DB::rollBack();
        $status = 'error';
        $content= 'Error al intentar registrar el ticket';
    }
        if($request->employeeNumber){
            if(auth()->user()->isAdministrator()){
                return redirect()
                ->route('administrator.ticket.create',['guest'=>True])
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            else{
                return redirect()
                ->route('coordinator.ticket.create',['guest'=>True])
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
        }
        //De otro modo el ticket es para quien está llamando la función
        else{
            if(auth()->user()->isAdministrator()){
                return redirect()
                ->route('administrator.ticket.create')
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            elseif(auth()->user()->isCoordinator()){
                return redirect()
                ->route('coordinator.ticket.create')
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            elseif(auth()->user()->isAssistant()){
                return redirect()
                ->route('assistant.ticket.create')
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            elseif(auth()->user()->isAgent()){
                return redirect()
                ->route('agent.ticket.create')
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            elseif(auth()->user()->isUser()){
                return redirect()
                ->route('user.ticket.create')
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            //Cambiar la siguiente ruta por invitado
            else{
                return redirect()->route('user.ticket.create')
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
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
        $this->updateTickets();
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
        $this->updateTickets();
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
        $status='success';
        $content='Se editó con éxito la descripción del ticket';
        $this->updateTickets();
        try{
            $ticket->ticketDescription = $request->description;
            $content='Se editó con éxito la descripción del ticket '.$ticket->idTicket;
            $ticket->update();
        }catch(\Throwable $th){
            DB::rollBack();
            $status = 'error';
            $content= 'Error al intentar editar la descripción del ticket '.$ticket->idTicket;
        }
        if($option==1)
            if(auth()->user()->isAdministrator()){
                return redirect()
                ->route('administrator.ticket.inbox',['department'=>$ticket->activity->subarea->department])
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            else{
                return redirect()
                ->route('coordinator.ticket.inbox',['department'=>$ticket->activity->subarea->department])
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
        elseif($option==2){
            if(auth()->user()->isAdministrator()){
                return redirect()->route('administrator.ticket.notAssigned',['department'=>$ticket->activity->subarea->department])
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            else{
                return redirect()->route('coordinator.ticket.notAssigned',['department'=>$ticket->activity->subarea->department])
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
        }
        else{
            if(auth()->user()->isAdministrator()){
                return redirect()
                ->route('administrator.ticket.mytickets',$ticket->employeeNumber)
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            elseif(auth()->user()->isCoordinator()){
                return redirect()
                ->route('coordinator.ticket.mytickets',$ticket->employeeNumber)
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            elseif(auth()->user()->isAssistant()){
                return redirect()
                ->route('assistant.ticket.mytickets',$ticket->employeeNumber)
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            elseif(auth()->user()->isAgent()){
                return redirect()
                ->route('agent.ticket.mytickets',$ticket->employeeNumber)
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            else{
                return redirect()
                ->route('user.ticket.mytickets',$ticket->employeeNumber)
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }         
        }
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
        $status='success';
        $content='';
        $this->updateTickets();
        try{
            if($ticketOption==1){
                if($ticket->idStatus==4){
                    $ticket->idStatus=5;
                    $content='Se reabrió el ticket '.$ticket->idTicket.' con éxito';
                }
                else{
                    
                    $ticket->idStatus=7;
                    $content='Se reabrió el ticket '.$ticket->idTicket.' con éxito';
                }
            }
            elseif($ticketOption==2){
                $ticket->idStatus=3;
                $status='warning';
                $content='Se canceló el ticket '.$ticket->idTicket;
            }
            else{
                $ticket->idStatus=4;
                $content='Se cerró el ticket '.$ticket->idTicket;
                $ticket->closeDate=Carbon::now();
            }
            $ticket->update();
        }catch(\Throwable $th){
            DB::rollBack();
            $status = 'error';
            $content= 'Error al intentar modificar el estado del ticket '.$ticket->idTicket;
        }
        if($option==1)
            if(auth()->user()->isAdministrator()){
                return redirect()
                ->route('administrator.ticket.inbox',['department'=>$ticket->activity->subarea->department])
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            else{
                return redirect()
                ->route('coordinator.ticket.inbox',['department'=>$ticket->activity->subarea->department])
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
        elseif($option==2){
            if(auth()->user()->isAdministrator()){
                return redirect()->route('administrator.ticket.notAssigned',['department'=>$ticket->activity->subarea->department])
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            else{
                return redirect()->route('coordinator.ticket.notAssigned',['department'=>$ticket->activity->subarea->department])
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
        }
        else{
            if(auth()->user()->isAdministrator()){
                return redirect()
                ->route('administrator.ticket.mytickets',$ticket->employeeNumber)
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            elseif(auth()->user()->isCoordinator()){
                return redirect()
                ->route('coordinator.ticket.mytickets',$ticket->employeeNumber)
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            elseif(auth()->user()->isAssistant()){
                return redirect()
                ->route('assistant.ticket.mytickets',$ticket->employeeNumber)
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            elseif(auth()->user()->isAgent()){
                return redirect()
                ->route('agent.ticket.mytickets',$ticket->employeeNumber)
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }
            else{
                return redirect()
                ->route('user.ticket.mytickets',$ticket->employeeNumber)
                ->with('process_result',[
                    'status'=>$status,
                    'content'=>$content
                ]);
            }         
        }
    }

   


}
