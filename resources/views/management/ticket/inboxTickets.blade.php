@extends('layouts.main')
@section('title', 'Ticket')

@section('icon_title')
<i class="fas fa-ticket-alt"></i>

@endsection

@section('content')
          
<div class="col-sm-12 offset-0">
    <h4 class="text-center aler alert-info">Bandeja de entrada</h4>
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
                    <td>
                    <a href="{{route('administrator.ticket.edit', ['ticket'=>$ticket])}}" class="btn
                        btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="{{route('administrator.ticket.show', ['ticket'=>$ticket])}}" class="btn
                        btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                        @if(($ticket->idStatus==3 || $ticket->idStatus==4 || $ticket->idStatus==6)&& auth()->user()->isAdministrator())
                        <form action="{{route('administrator.ticket.destroy', ['ticket'=>$ticket])}}"
                                method="POST" class="d-inline">
                                {{ csrf_field() }}
                                <button type="submit" onclick="return confirm('¿Seguro que desea cancelar?');" class="btn btn-danger btn-sm"><i class="fas fa-undo-alt"></i></button>
                            </form >
                        @endif
                      
                            
                    <a href="{{route('administrator.message.create',['ticket'=>$ticket])}}"class="btn btn-info btn-sm">
                    <i class="far fa-comments"></i>
                    </a>
                    <a >
                    <a class="btn btn-light btn-sm" href="{{route('administrator.file.create',['ticket'=>$ticket])}}">
                    <i class="fas fa-file-upload"></i>
                    </a>
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