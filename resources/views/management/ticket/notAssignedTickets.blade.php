@extends('layouts.main')
@section('title', 'Ticket')

@section('icon_title')
<i class="fas fa-ticket-alt"></i>

@endsection

@section('content')
          
<div class="col-sm-12 offset-0">
    <h4 class="text-center aler alert-info">Tickets no asignados de {{$department->departmentName}}</h4>
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
                    <td>
                        
                    <a href="{{route('administrator.ticket.show', ['ticket'=>$ticket,'option'=>2])}}" class="btn
                        btn-warning btn-sm"><i class="fas fa-eye"></i></a>
                        <a href="{{route('administrator.ticket.edit', ['ticket'=>$ticket,'option'=>2])}}" class="btn
                        btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="{{route('administrator.ticket.transfer',['ticket'=>$ticket,'option'=>1])}}" class="btn-outline-secondary btn-sm"><i class="fas fa-map-signs"></i></a>
                        <form action="{{route('administrator.ticket.destroy', ['ticket'=>$ticket,'ticketOption'=>2,'option'=>1])}}"
                            method="POST" class="d-inline">
                            {{ csrf_field() }}
                            
                            <button type="submit" onclick="return confirm('¿Seguro que desa cancelar?');" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>    
        {{$tickets->render()}}
    @else
        <h4 class="text-center aler alert-warning"> No hay registro de tickets para {{$department->departmentName}} </h4>
    @endif
</div>
@endsection