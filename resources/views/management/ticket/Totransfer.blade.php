@extends('layouts.main')
@section('title', 'Reasigna el ticket')

@section('icon_title')
<i class="fas fa-map-signs"></i>
@endsection
@section('content')
<div class="col-sm-12 offset-0" id="ticket">
  <h4 class="text-center alert alert-info ">Reasigna ticket</h4>

  @if(Auth::user()->isAdministrator())
      <form action="{{route('administrator.ticket.reasign',['ticket'=>$ticket,'option'=>$option])}}" method="POST">
  @else
      <form action="{{route('coordinator.ticket.reasign',['ticket'=>$ticket,'option'=>$option])}}" method="POST">
  @endif
  {{ csrf_field() }}
    Elige al técnico para este ticket
    <select class="form-control" name="idTechnician">
                   <option value="">Escoge  el agente</option>
                   @foreach($agents as $agent)
                   <option value="{{$agent->idUser}}">{{$agent->name}}</option>
                   @endforeach
                    </select>
                    <br><br>
                    <input type="submit" class="btn btn-success" value="Reasignar">
                    <a href="{{ URL::previous() }}" class="btn btn-info">Regresar</a>
                    <br>
                    <br>
</form>
</div>
               
                  
@endsection
