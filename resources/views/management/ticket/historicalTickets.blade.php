@extends('layouts.main')
@section('title', 'Ticket')

@section('icon_title')
<i class="fas fa-ticket-alt"></i>

@endsection

@section('content')
          
<div class="col-sm-12 offset-0">
    <h4 class="text-center aler alert-info">Bandeja de histórico</h4>
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
                    {{--dd($ticket)--}}
                    <td>{{$ticket->idTicket}}</td>
                    <td>{{$ticket->activity->subarea->department->departmentName}}</td>
                     <td>{{$ticket->activity->subarea->subareaName}}</td>
                    <td>{{$ticket->activity->activityName}}</td>
                    <td>{{$ticket->activity->days}}</td>
                    <td>{{$ticket->startDate}}</td>
                    <td>{{$ticket->limitDate}}</td>
                    <td>{{$ticket->status->statusName}}</td>
                    <td></td>
                    <td></td>
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