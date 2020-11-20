@extends('layouts.main')
@section('title', 'Ticket')

@section('icon_title')
<i class="fas fa-ticket-alt"></i>

@endsection

@section('content')
          
<div class="col-sm-12 offset-0">
    <h4 class="text-center aler alert-info">Tickets por atender</h4>
    @if(count($tickets)>0)
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th scope="col">Departamento</th>
                <th scope="col">Subárea</th>
                <th scope="col">Servicio</th>
                <th scope="col">Días</th>
                <th scope="col">Fecha Inicio</th>
                <th scope="col">Fecha Fin</th>
                <th scope="col">Estado</th>
                <th scope="col">Técnico</th>
                <th scope="col">Temporal</th>
                <th scope="col">Acciones</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($tickets as $ticket)
                <tr>
                    <td>{{$ticket->idTicket}}</td>
                    <td>{{$ticket->activity->subarea->department->departmentName}}</td>
                     <td>{{$ticket->activity->subarea->subareaName}}</td>
                    <td>{{$ticket->activity->activityName}}</td>
                    <td>{{$ticket->activity->days}}</td>
                    <td>{{$ticket->startDate}}</td>
                    <td>{{$ticket->limitDate}}</td>
                    <td>{{$ticket->status->statusName}}</td>
                    @if($ticket->user)
                    <td>{{$ticket->user->name}}</td>
                    @else
                    <td>No asignado</td>
                    @endif
                    <td>
                    <a href="" class="btn
                        btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                    @if($ticket->idStatus==1)
                        <a href="{{route('agent.ticket.technician',['user'=>auth()->user(),'ticket'=>$ticket])}}" class="btn btn-success 
                        btn-sm"><i class="fas fa-sign-in-alt"></i></a>
                    @endif
                        <form action=""
                            method="POST" class="d-inline">
                            {{ csrf_field() }}
                           
                            <input type="submit" onclick="return confirm('¿Seguro que desea borrar?');" class="btn btn-danger btn-sm"  value="X">
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>    
        {{$tickets->render()}}
    @else
        <h4 class="text-center aler alert-warning"> No hay tickets para que atiendas {{auth()->user()->name}} </h4>
    @endif
</div>
@endsection