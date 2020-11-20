@extends('layouts.main')
@section('title', 'Ticket')

@section('icon_title')
<i class="fas fa-ticket-alt"></i>

@endsection

@section('content')
<div class="col-sm-12 offset-0" id="ticket">
  <h4 class="text-center alert alert-info ">Actualiza la descripción del ticket</h4>
  @if(Auth::user()->isAdministrator())
  <form action="{{route('administrator.ticket.update',['ticket'=>$ticket,'option'=>$option])}}" method="POST">
  @elseif(Auth::user()->isCoordinator())
  <form action="{{route('coordinator.ticket.update',['ticket'=>$ticket,'option'=>$option])}}" method="POST">
  @elseif(Auth::user()->isAssistant())
  <form action="{{route('assistant.ticket.update',['ticket'=>$ticket,'option'=>$option])}}" method="POST">
  @elseif(Auth::user()->isAgent())
  <form action="{{route('agent.ticket.update',['ticket'=>$ticket,'option'=>$option])}}" method="POST">
  @else
  <form action="{{route('user.ticket.update',['ticket'=>$ticket,'option'=>$option])}}" method="POST">
  @endif
  {{ csrf_field() }}
  <br><br>
  

  Descripción
      <textarea class="form-control" required name="description" rows="3" value=>{{$ticket->ticketDescription}}</textarea>
  <br><br>
 
  <br><br>
  <input type="submit" class="btn btn-success" value="Actualizar">
  <a href="{{ URL::previous() }}" class="btn btn-info">Regresar</a>
</form>
</div>
               
                  
@endsection
