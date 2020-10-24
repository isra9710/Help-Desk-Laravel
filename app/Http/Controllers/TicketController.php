<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Activity;
use App\Models\Subarea;
use App\Models\Department;
use App\Models\User;
use App\Models\Role;
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
    public function historical(Department $department)
    {
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
    public function inbox(Department $department=null)
    {
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
    public function notAssigned(Department $department)
    {
        //
        $subareasSideBar = Subarea::all();
        $departmentsSideBar = Department::all();
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





    /**
     * Show the form for creating a new resource.
     *@param boolean $guest
     * @return \Illuminate\Http\Response
     */
    public function create($guest=NULL)
    {
        //
        $subareasSideBar = Subarea::all();
        $subareas = Subarea::all();
        $departmentsSideBar = Department::all();
        $departments = Department::all();
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
        $activity = Activity::where('idActivity', $request->idActivity);
        $ticket = new Ticket();
        /*
        Los siguiente datos los obtenemos del formulario de registro ubicado en managment.user.index
        */
        if($request->employeeNumber){
            $ticket->idStaff = $request->employeeNumber;
        }
        else{
            $ticket->idStaff = Auth::user()->idUser;
        }
        $ticket->status=1;
        $ticket->idActivity = $request->idActivity;
        $ticket->startDate = Carbon::now();
        $ticket->limitDate = Carbon::now()->subDays($activity->days);
        $ticket->ticketDescription = $request->description;
        $ticket->doubt = $request->doubt;
        if($request->file)
        {
            
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
    }
}
