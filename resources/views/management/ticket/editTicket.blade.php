@extends('layouts.main')
@section('title', 'Ticket')

@section('icon_title')
<i class="fas fa-ticket-alt"></i>

@endsection

@section('content')
<div class="col-sm-12 offset-0" id="ticket">
  <h4 class="text-center alert alert-info ">Actualiza la descripción del ticket</h4>
  <form>
  {{ csrf_field() }}
  <br><br>
  

  Descripción
      <textarea class="form-control" required name="description" rows="3">Aquí va la descripción a actualizar</textarea>
  <br><br>
 
  <br><br>
  @if(Auth::user()->isAdministrator())
      <a href="{{route('administrator.ticket.update',['ticket'=>$ticket])}}" class="btn btn-primary">Actualizar</a>
  @elseif(Auth::user()->isCoordinator())
      <a href="{{route('coordinator.ticket.update',['ticket'=>$ticket])}}" class="btn btn-primary">Actualizar</a>
  @elseif(Auth::user()->isAssistant())
     <a href="{{route('assistant.ticket.update',['ticket'=>$ticket])}}" class="btn btn-primary">Actualizar</a>
  @elseif(Auth::user()->isAgent())
     <a href="{{route('agent.ticket.update',['ticket'=>$ticket])}}" class="btn btn-primary">Actualizar</a>
  @else
      <a href="{{route('user.ticket.update',['ticket'=>$ticket])}}">Actualizar</a>
  @endif
  <br><br>
</form>
</div>
               
                  
@endsection
