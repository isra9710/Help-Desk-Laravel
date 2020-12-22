@extends('layouts.main')
@section('title', 'Reportes')


@section('icon_title')
<i class="far fa-chart-bar"></i>
@endsection


@section('content')
@if(auth()->user()->isAdministrator())
    <form method="POST"   action ="{{route('administrator.chart.ticket.subarea')}}" id="form">
@else
<form method="POST"   action ="{{route('coordinator.chart.ticket.subarea')}}" id="form">
@endif
    {{ csrf_field() }}
    Elige la subárea 
    <select class="form-control" name="idSubarea">
                   <option value="">Escoge la subárea</option>
                   @foreach($subareas as $subarea)
                   <option value="{{$subarea->idSubarea}}">{{$subarea->subareaName}}</option>
                   @endforeach
                    </select>
                    <br>
                    <input type="submit" class="btn btn-success" value="Generar">
</form>
<br>
@endsection





