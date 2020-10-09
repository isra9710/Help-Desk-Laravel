<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Activity;
use App\Models\Subarea;
use App\Models\Department;
use App\Models\User;
use App\Models\Role;


use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *boolean $noAsignados
     * @return \Illuminate\Http\Response
     */
    public function index(Department $department=null, Subarea $subarea=null,$noAsignados=null)
    {
        //
        $subareasSideBar = Subarea::all();
        $departmentsSideBar = Department::all();
        $rolesSideBar = Role::all();
        $tickets = "";
        /*Si el departamento no es null, significa que se quieren ver
            los tickets de un departamento en especifico
        */
        if($department!=NULL)
        {
            if($subarea !=NULL)//Si subarea es diferente de null significa que un agente está solicitando ver sus tickets
            {
                $tickets = Ticket::with('subareas')->where('idSubarea',$subarea)->paginate(15);
            }
            /*Si no asignados es verdadero, significa que se quiere ver
                los tickets de usuarios que tienen duda acerca de a qué 
                subárea asignar su ticket
            */
            elseif($noAsignados)
            {
                $tickets = Ticket::where('idDepartment',($department->idDepartment))->where('doubt',$noAsignados)->paginate(15);
            }
        
            else//De otro modo se quiere ver el historico de un departamento
            {
                
                $tickets=Ticket::join('activities','tickets.idActivity', '=', 'activities.idActivity')
                ->join('subareas','activities.idSubarea', '=', 'subareas.idSubarea')
                ->join('departments', 'subareas.idDepartment', '=', 'departments.idDepartment')
                ->select('tickets.*')->where('departments.idDepartment',$department->idDepartment)
                ->paginate(15);
                ;
                //$tickets = Ticket::where('idDepartment',($department->idDepartment))->paginate(15);
            }
            
        }
        else//De otro modo es un administrador quien quiere ver  el historico de todos los tickets y no se hace un filtro, se le muestran todos
        {
            $tickets = Ticket::paginate(15);
        }

        return view ('management.ticket.historicalTickets',['departmentsSideBar'=>$departmentsSideBar,'rolesSideBar'=>$rolesSideBar,'subareasSideBar'=>$subareasSideBar,'tickets'=>$tickets]);
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
