@extends('layouts.main')
@section('title', 'Reportes')


@section('icon_title')
<i class="far fa-chart-bar"></i>
@endsection


@section('content')
    @if(auth()->user()->isAdministrator())
    <form method="POST"   action ="{{route('administrator.chart.ticket.technician')}}" id="form">
    @else
    <form method="POST"   action ="{{route('coordinator.chart.ticket.technician')}}" id="form">
    @endif
    {{ csrf_field() }}
    Elige al técnico 
    <select class="form-control" name="idTechnician">
                   <option value="">Escoge  el agente</option>
                   @foreach($agents as $agent)
                   <option value="{{$agent->idUser}}">{{$agent->name}}</option>
                   @endforeach
                    </select>
                    <br>
                    <input type="submit" class="btn btn-success" value="Generar">
</form>
<br>
@endsection





