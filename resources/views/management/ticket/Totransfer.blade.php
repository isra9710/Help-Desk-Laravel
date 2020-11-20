@extends('layouts.main')
@section('title', 'Añadir archivo')

@section('icon_title')
<i class="fas fa-ticket-alt"></i>
@endsection
@section('content')
<div class="col-sm-12 offset-0" id="ticket">
  <h4 class="text-center alert alert-info ">Reasigna ticket</h4>
  @if(Auth::user()->isAdministrator())
      <form>
    Elige al técnico para este ticket
  @if(Auth::user()->isAdministrator())
      <a href="{{route('administrator.ticket.reasign',['department'=>$ticket->activity->subarea->department])}}" class="btn btn-info">Reasignar</a>
  @else
      <a href="{{route('coordinator.ticket.reasign',['department'=>$ticket->activity->subarea->department])}}" class="btn btn-info">Reasignar</a>
  @endif
</form>
</div>
               
                  
@endsection
