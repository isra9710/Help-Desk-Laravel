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
             
                <th scope="col">Fecha Inicio</th>
                <th scope="col">Fecha estimada fin</th>
                <th scope="col">Tiempo abierto</th>
                <th scope="col">Fecha de cierre</th>
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
                    <td>{{$ticket->created_at}}</td>
                    <td>{{$ticket->limitDate}}</td>
                    @if($ticket->closeDate)
                    <td>{{ date_diff(new \DateTime($ticket->startDate), new \DateTime($ticket->closeDate))->format("%m Meses, %d días %h horas") }}</td>
                    @else
                    <td>{{$ticket->created_at->diffForHumans()}}</td>
                    @endif
                    <td>{{$ticket->closeDate}}</td>
                    <td>{{$ticket->status->statusName}}</td>
                    <td>
                    @if(auth()->user()->isAdministrator())
                    <a href="{{route('administrator.ticket.edit', ['ticket'=>$ticket,'option'=>1])}}" class="btn
                        btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="{{route('administrator.ticket.show', ['ticket'=>$ticket,'option'=>1])}}" class="btn
                        btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                        <a href="{{route('administrator.message.create',['ticket'=>$ticket,'option'=>1])}}"class="btn btn-info btn-sm">
                        <i class="far fa-comments"></i>
                        </a>
                        <br>
                        <a class="btn btn-light btn-sm" href="{{route('administrator.file.create',['ticket'=>$ticket,'option'=>1])}}">
                        <i class="fas fa-file-upload"></i>
                        </a>
                        <br>
                    @else
                    <a href="{{route('coordinator.ticket.edit', ['ticket'=>$ticket,'option'=>1])}}" class="btn
                        btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="{{route('coordinator.ticket.show', ['ticket'=>$ticket,'option'=>1])}}" class="btn
                        btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                        <a href="{{route('coordinator.message.create',['ticket'=>$ticket,'option'=>1])}}"class="btn btn-info btn-sm">
                        <i class="far fa-comments"></i>
                        </a>
                        <a class="btn btn-light btn-sm" href="{{route('coordinator.file.create',['ticket'=>$ticket,'option'=>1])}}">
                        <i class="fas fa-file-upload"></i>
                        </a>
                    @endif
                    
                        @if(($ticket->idStatus==4 || $ticket->idStatus==6) && auth()->user()->isAdministrator())
                        <form action="{{route('administrator.ticket.destroy', ['ticket'=>$ticket,'ticketOption'=>1,'option'=>1])}}"
                                method="POST" class="d-inline">
                                {{ csrf_field() }}
                                <button type="submit" onclick="return confirm('¿Seguro que desea reabrir?');" class="btn btn-danger btn-sm"><i class="fas fa-undo-alt"></i></button>
                            </form >
                        @else
                            @if(($ticket->idStatus==1 || $ticket->idStatus==2 || $ticket->idStatus==5 || $ticket->idStatus==7) && auth()->user()->isAdministrator())
                                <form action="{{route('administrator.ticket.destroy', ['ticket'=>$ticket,'ticketOption'=>2,'option'=>1])}}"
                                    method="POST" class="d-inline">
                                    {{ csrf_field() }}
                                    <button type="submit" onclick="return confirm('¿Seguro que desea cancelar?');" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                                </form >
                            @endif
                            @if(($ticket->idStatus==1 || $ticket->idStatus==2 || $ticket->idStatus==5 || $ticket->idStatus==7) && auth()->user()->isAdministrator())
                                <form action="{{route('administrator.ticket.destroy', ['ticket'=>$ticket,'ticketOption'=>3,'option'=>1])}}"
                                    method="POST" class="d-inline">
                                    {{ csrf_field() }}
                                    <button type="submit" onclick="return confirm('¿Seguro que desea cerrar?');" class="btn btn-danger btn-sm"><i class="fas fa-check"></i></button>
                                </form >
                            @endif
                        @endif
                      
                            
                    
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