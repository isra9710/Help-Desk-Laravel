@extends('layouts.main')
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
      <input type="text" class="form-control" readonly value="{{$ticket->startDate}}">

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
      <textarea class="form-control" readonly  rows="3" value="{{$ticket->description}}"></textarea>
  <br><br>
  @if($option==1)
    @if(Auth::user()->isAdministrator())
        <a href="{{route('administrator.ticket.inbox',['department'=>$ticket->activity->subarea->department])}}" class="btn btn-info">Regresar</a>
    @else
        <a href="{{route('coordinator.ticket.inbox',['department'=>$ticket->activity->subarea->department])}}" class="btn btn-info">Regresar</a>
    @endif
  @else
  @if(Auth::user()->isAdministrator())
        <a href="{{route('administrator.ticket.notAssigned',['department'=>$ticket->activity->subarea->department])}}" class="btn btn-info">Regresar</a>
    @else
        <a href="{{route('coordinator.ticket.notAssigned',['department'=>$ticket->activity->subarea->department])}}" class="btn btn-info">Regresar</a>
    @endif
  @endif
</form>
</div>
               
                  
@endsection

