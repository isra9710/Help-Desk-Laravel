@extends('layouts.main')
@section('title', 'Ticket')

@section('icon_title')
<i class="fas fa-ticket-alt"></i>

@endsection

@section('content')
          
<div class="col-sm-12 offset-0">
    <h4 class="text-center aler alert-info">Bandeja de histórico de {{$department->departmentName}}</h4>
    @if(count($tickets)>0)
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th scope="col">Departamento</th>
                <th scope="col">Subárea</th>
                <th scope="col">Servicio</th>
                <th scope="col">Días estimados</th>
                <th scope="col">Fecha Inicio</th>
                <th scope="col">Fecha Fin</th>
                <th scope="col">Fecha Cierre</th>
                <th scope="col">Estado</th>
                <th scope="col">Ver detalles</th>
               
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
                    <td>{{$ticket->created_at}}</td>
                    <td>{{$ticket->limitDate}}</td>
                    <td>{{$ticket->closeDate}}
                    <td>{{$ticket->status->statusName}}</td>
                    <td>
                    @if(auth()->user()->isAdministrator())
                    <a href="{{route('administrator.ticket.show', ['ticket'=>$ticket,'option'=>3])}}" class="btn
                        btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                    @else
                    <a href="{{route('coordinator.ticket.show', ['ticket'=>$ticket,'option'=>3])}}" class="btn
                        btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                    @endif
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