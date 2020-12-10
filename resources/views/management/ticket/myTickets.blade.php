@extends('layouts.main')
@section('title', 'Ticket')

@section('icon_title')
<i class="fas fa-ticket-alt"></i>

@endsection

@section('content')
          
<div class="col-sm-12 offset-0">
    <h4 class="text-center aler alert-info">Mis tickets</h4>
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
                    <td>{{$ticket->created_at}}</td>
                    <td>{{$ticket->limitDate}}</td>
                    <td>{{$ticket->status->statusName}}</td>
                    <td>
                    @if(auth()->user()->isAdministrator())
                    <a href="{{route('administrator.ticket.edit', ['ticket'=>$ticket,'option'=>1])}}" class="btn
                        btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        
                        <a href="{{route('administrator.ticket.show', ['ticket'=>$ticket,'option'=>3])}}" class="btn
                        btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                        <a href="{{route('administrator.message.create',['ticket'=>$ticket,'option'=>3])}}"class="btn btn-info btn-sm">
                        <i class="far fa-comments"></i>
                        </a>
                        <br>
                        <a class="btn btn-light btn-sm" href="{{route('administrator.file.create',['ticket'=>$ticket,'option'=>3])}}">
                        <i class="fas fa-file-upload"></i>
                        </a>
                        <br>

                        <!--El siguiente código es para saber en qué estado se encuentra el ticket
                            dependiendo de éso, se van a mostrar ciertas opciones
                        -->
                        @if($ticket->idStatus==4 || $ticket->idStatus==6)
                        <form action="{{route('administrator.ticket.destroy', ['ticket'=>$ticket,'ticketOption'=>1,'option'=>3])}}"
                                method="POST" class="d-inline">
                                {{ csrf_field() }}
                                <button type="submit" onclick="return confirm('¿Seguro que desea reabrir?');" class="btn btn-danger btn-sm"><i class="fas fa-undo-alt"></i></button>
                            </form >
                        @else
                            @if($ticket->idStatus==1 || $ticket->idStatus==2 || $ticket->idStatus==5 || $ticket->idStatus==7)
                                <form action="{{route('administrator.ticket.destroy', ['ticket'=>$ticket,'ticketOption'=>2,'option'=>3])}}"
                                    method="POST" class="d-inline">
                                    {{ csrf_field() }}
                                    <button type="submit" onclick="return confirm('¿Seguro que desea cancelar?');" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                                </form >
                            @endif
                            @if($ticket->idStatus==1 || $ticket->idStatus==2 || $ticket->idStatus==5 || $ticket->idStatus==7)
                                <form action="{{route('administrator.ticket.destroy', ['ticket'=>$ticket,'ticketOption'=>3,'option'=>3])}}"
                                    method="POST" class="d-inline">
                                    {{ csrf_field() }}
                                    <button type="submit" onclick="return confirm('¿Seguro que desea cerrar?');" class="btn btn-danger btn-sm"><i class="fas fa-check"></i></button>
                                </form >
                            @endif
                        @endif



                    @elseif(auth()->user()->isCoordinator())
                        <a href="{{route('coordinator.ticket.edit', ['ticket'=>$ticket,'option'=>3])}}" class="btn
                            btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="{{route('coordinator.ticket.show', ['ticket'=>$ticket,'option'=>3])}}" class="btn
                            btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                            <a href="{{route('coordinator.message.create',['ticket'=>$ticket,'option'=>3])}}"class="btn btn-info btn-sm">
                            <i class="far fa-comments"></i>
                            </a>
                            <a class="btn btn-light btn-sm" href="{{route('coordinator.file.create',['ticket'=>$ticket,'option'=>3])}}">
                            <i class="fas fa-file-upload"></i>
                            </a>
                            @if($ticket->idStatus==4 || $ticket->idStatus==6)
                        <form action="{{route('coordinator.ticket.destroy', ['ticket'=>$ticket,'ticketOption'=>1,'option'=>3])}}"
                                method="POST" class="d-inline">
                                {{ csrf_field() }}
                                <button type="submit" onclick="return confirm('¿Seguro que desea reabrir?');" class="btn btn-danger btn-sm"><i class="fas fa-undo-alt"></i></button>
                            </form >
                        @else
                            @if($ticket->idStatus==1 || $ticket->idStatus==2 || $ticket->idStatus==5 || $ticket->idStatus==7)
                                <form action="{{route('coordinator.ticket.destroy', ['ticket'=>$ticket,'ticketOption'=>2,'option'=>3])}}"
                                    method="POST" class="d-inline">
                                    {{ csrf_field() }}
                                    <button type="submit" onclick="return confirm('¿Seguro que desea cancelar?');" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                                </form >
                            @endif
                            
                        @endif




                    @elseif(auth()->user()->isAssistant())
                    <a href="{{route('assistant.ticket.edit', ['ticket'=>$ticket,'option'=>1])}}" class="btn
                        btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="{{route('assistant.ticket.show', ['ticket'=>$ticket,'option'=>1])}}" class="btn
                        btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                        <a href="{{route('assistant.message.create',['ticket'=>$ticket,'option'=>3])}}"class="btn btn-info btn-sm">
                        <i class="far fa-comments"></i>
                        </a>
                        <a class="btn btn-light btn-sm" href="{{route('assistant.file.create',['ticket'=>$ticket,'option'=>3])}}">
                        <i class="fas fa-file-upload"></i>
                        </a>

                        @if($ticket->idStatus==4 || $ticket->idStatus==6)
                        <form action="{{route('assistant.ticket.destroy', ['ticket'=>$ticket,'ticketOption'=>1,'option'=>1])}}"
                                method="POST" class="d-inline">
                                {{ csrf_field() }}
                                <button type="submit" onclick="return confirm('¿Seguro que desea reabrir?');" class="btn btn-danger btn-sm"><i class="fas fa-undo-alt"></i></button>
                            </form >
                        @else
                            @if($ticket->idStatus==1 || $ticket->idStatus==2 || $ticket->idStatus==5 || $ticket->idStatus==7)
                                <form action="{{route('assistant.ticket.destroy', ['ticket'=>$ticket,'ticketOption'=>2,'option'=>1])}}"
                                    method="POST" class="d-inline">
                                    {{ csrf_field() }}
                                    <button type="submit" onclick="return confirm('¿Seguro que desea cancelar?');" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                                </form >
                            @endif
                        @endif




                    @elseif(auth()->user()->isAgent())
                        <a href="{{route('agent.ticket.edit', ['ticket'=>$ticket,'option'=>1])}}" class="btn
                        btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="{{route('agent.ticket.show', ['ticket'=>$ticket,'option'=>1])}}" class="btn
                        btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                        <a href="{{route('agent.message.create',['ticket'=>$ticket,'option'=>3])}}"class="btn btn-info btn-sm">
                        <i class="far fa-comments"></i>
                        </a>
                        <a class="btn btn-light btn-sm" href="{{route('agent.file.create',['ticket'=>$ticket,'option'=>3])}}">
                        <i class="fas fa-file-upload"></i>
                        </a>
                        @if($ticket->idStatus==4 || $ticket->idStatus==6)
                        <form action="{{route('agent.ticket.destroy', ['ticket'=>$ticket,'ticketOption'=>1,'option'=>3])}}"
                                method="POST" class="d-inline">
                                {{ csrf_field() }}
                                <button type="submit" onclick="return confirm('¿Seguro que desea reabrir?');" class="btn btn-danger btn-sm"><i class="fas fa-undo-alt"></i></button>
                            </form >
                        @else
                            @if($ticket->idStatus==1 || $ticket->idStatus==2 || $ticket->idStatus==5 || $ticket->idStatus==7)
                                <form action="{{route('agent.ticket.destroy', ['ticket'=>$ticket,'ticketOption'=>2,'option'=>3])}}"
                                    method="POST" class="d-inline">
                                    {{ csrf_field() }}
                                    <button type="submit" onclick="return confirm('¿Seguro que desea cancelar?');" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                                </form >
                            @endif
                         
                        @endif



                    @else
                        @if(auth()->user()->isUser())
                            <a href="{{route('user.ticket.edit', ['ticket'=>$ticket,'option'=>1])}}" class="btn
                            btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="{{route('user.ticket.show', ['ticket'=>$ticket,'option'=>1])}}" class="btn
                            btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                            <a href="{{route('user.message.create',['ticket'=>$ticket,'option'=>3])}}"class="btn btn-info btn-sm">
                            <i class="far fa-comments"></i>
                            </a>
                            <a class="btn btn-light btn-sm" href="{{route('user.file.create',['ticket'=>$ticket,'option'=>3])}}">
                            <i class="fas fa-file-upload"></i>
                            </a>
                        @endif

                        @if($ticket->idStatus==4 || $ticket->idStatus==6)
                        <form action="{{route('administrator.ticket.destroy', ['ticket'=>$ticket,'ticketOption'=>1,'option'=>1])}}"
                                method="POST" class="d-inline">
                                {{ csrf_field() }}
                                <button type="submit" onclick="return confirm('¿Seguro que desea reabrir?');" class="btn btn-danger btn-sm"><i class="fas fa-undo-alt"></i></button>
                            </form >
                        @else
                            @if($ticket->idStatus==1 || $ticket->idStatus==2 || $ticket->idStatus==5 || $ticket->idStatus==7)
                                <form action="{{route('administrator.ticket.destroy', ['ticket'=>$ticket,'ticketOption'=>2,'option'=>1])}}"
                                    method="POST" class="d-inline">
                                    {{ csrf_field() }}
                                    <button type="submit" onclick="return confirm('¿Seguro que desea cancelar?');" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                                </form >
                            @endif
                          
                        @endif
                    @endif
                    @if(($ticket->idStatus==4)&& ($ticket->polls()))
                            
                <a href="" data-toggle="modal" data-target="#modal-default" ><i class="fas fa-question-circle"></i></a>
                <div class="modal fade" id="modal-default">
                @if(auth()->user()->isAdministrator())
                <form action="{{route('administrator.poll.store',['ticket'=>$ticket])}}" method="POST">
                @elseif(auth()->user()->isCoordinator())
                <form action="{{route('administrator.poll.store')}}" method="GET">
                @elseif(auth()->user()->isAssistant())
                <form action="{{route('administrator.poll.store')}}" method="GET">
                @elseif(auth()->user()->isAgent())
                <form action="{{route('administrator.poll.store')}}" method="GET">
                @else
                <form action="{{route('administrator.poll.store')}}" method="GET">
                @endif 
                {{ csrf_field() }}

                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title">Encuesta de satsisfacción</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                    @foreach($questions as $question)
                    {{$question->question}}
                <input class="form-control" required name="{{$question->idQuestion}}" >
                    @endforeach              
                    Califica el servicio que se te brindó
                    <input type="number" class="form-control"  required name="score"
                        min="1" max="10">

                    </div>
                    <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    
                    <button type="submit" class="btn btn-success">Terminar encuesta</button>            
                    </div>
                    </form>
                </div>
            
                <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
                   @endif
            @endforeach
            </tbody>
        </table>    
        {{$tickets->render()}}
    @else
        <h4 class="text-center aler alert-warning"> No hay tickets registrados por ti {{auth()->user()->name}} </h4>
    @endif
</div>
@endsection