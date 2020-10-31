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
                    <td>
                        
                    <a href="{{route('administrator.ticket.edite', ['ticket'=>$ticket])}}" class="btn
                        btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="{{route('administrator.ticket.show', ['ticket'=>$ticket])}}" class="btn
                        btn-primary btn-sm"><i class="fas fa-eye"></i></a>

                    </td>
                    <td>
                        <form action="{{route('administrator.ticket.destroy', ['ticket'=>$ticket])}}"
                            method="POST" class="d-inline">
                            {{ csrf_field() }}
                           
                            <input type="submit" onclick="return confirm('¿Seguro que desa borrar?');" class="btn btn-danger btn-sm"  value="X">
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