@extends('layouts.mainGuest')
@section('title', 'Ticket')

@section('icon_title')
<i class="fas fa-ticket-alt"></i>

@endsection

@section('content')
<div class="col-sm-12 offset-0" id="ticket">
  <h4 class="text-center alert alert-info ">Detalles ticket</h4>
  
  <form>
<br><br>
ID
<input type="number" class="form-control" readonly value="{{$ticket->idTicket}}">
<br><br>
Número de empleado
      <input type="text" class="form-control" readonly value="{{$ticket->employeeNumber}}">

      <br><br>
     Técnico
      @if($ticket->idTechnician)
        <input type="text" class="form-control" readonly value="{{$ticket->user->name}}">
      <br><br>
      @else
        <input type="text" class="form-control" readonly value="Este ticket no ha sido atendido">

      <br><br>
      @endif

      Estado
      <input type="text" class="form-control" readonly value="{{$ticket->status->statusName}}">

      <br><br>
      Departamento
      <input type="text" class="form-control" readonly value="{{$ticket->activity->subarea->department->departmentName}}">

      <br><br>
      Subárea
      <input type="text" class="form-control" readonly value="{{$ticket->activity->subarea->subareaName}}">

      <br><br>
      Actividad
      <input type="text" class="form-control" readonly value="{{$ticket->activity->activityName}}">

      <br><br>
      Fecha de apertura
      <input type="text" class="form-control" readonly value="{{$ticket->created_at}}">

      <br><br>
      Fecha de cierre deseada
      <input type="text" class="form-control" readonly value="{{$ticket->limitDate}}">

      <br><br>
      Fecha de cierre
      @if($ticket->closeDate)
      <input type="text" class="form-control" readonly value="{{$ticket->closeDate}}">

      <br><br>
      @else
      <input type="text" class="form-control" readonly value="No se ha cerrado">
      <br><br>
      @endif
      Descripción

<input type="text" class="form-control" readonly   value="{{$ticket->ticketDescription}}">
<br><br>

<a href="{{route('login') }}" class="btn btn-info">Regresar</a>

<a data-toggle="modal" data-target="#modal-default" class="btn
                  btn-warning btn-sm"><i class="fas fa-edit"></i></a> 
<a class="btn btn-light btn-sm" href="{{route('guest.file.create',['ticket'=>$ticket])}}">
                  <i class="fas fa-file-upload"></i>
                  </a>
                  <a href="{{route('guest.message.create',['ticket'=>$ticket])}}"class="btn btn-info btn-sm">
                  <i class="far fa-comments"></i>
                  </a>
                  @if($ticket->idStatus==4 || $ticket->idStatus==6)
                       
                                <a href="{{route('guest.ticket.destroy', ['ticket'=>$ticket,'ticketOption'=>1])}}" 
                                   onclick="return confirm('¿Seguro que desea reabrir?');" class="btn btn-danger"><i class="fas fa-undo-alt"></i></a>
                         
                        @else
                            @if($ticket->idStatus==1 || $ticket->idStatus==2 || $ticket->idStatus==5 || $ticket->idStatus==7)
                               
                                <a href="{{route('guest.ticket.destroy', ['ticket'=>$ticket,'ticketOption'=>2])}}" 
                                   onclick="return confirm('¿Seguro que desea cancelar?');" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></a>
                            @endif
                            @if($ticket->idStatus==1 || $ticket->idStatus==2 || $ticket->idStatus==5 || $ticket->idStatus==7)
                                
                                    <a href="{{route('guest.ticket.destroy', ['ticket'=>$ticket,'ticketOption'=>3])}}" 
                                   onclick="return confirm('¿Seguro que desea cerrar?');" class="btn btn-success btn-sm"><i class="fas fa-check"></i></a>
                                    
                            @endif
                        @endif
</form>

<div class="modal fade" id="modal-default">
         <form action="{{route('guest.ticket.update', ['ticket'=>$ticket])}}" method="GET">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Editar descripción del ticket</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            
            Descripción actual del ticket
          <input class="form-control" required  value="{{$ticket->ticketDescription}}"name="ticketDescription" >
              
              
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            
              <button type="submit" class="btn btn-success">Editar ticket</button>            
            </div>
            </form>
          </div>
       
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>  
</div>
     
                  
@endsection

