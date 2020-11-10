@extends('layouts.main')

@section('title', 'Actividades')

@section('icon_title')
    <i class="fas fa-clipboard"></i>
@endsection


@section('content')
        <div class="row">
            <div class="col-sm-8 offset-2">
                <h4 class="text-center alert alert-info ">Editar Actividad</h4>
                @if(auth()->user()->isAdministrator())
                <form action="{{route('administrator.activity.update',['subarea'=>$subarea,'activity'=>$activity])}}" method="POST">
                @else
                <form action="{{route('coordinator.activity.update',['subarea'=>$subarea,'activity'=>$activity])}}" method="POST">
                @endif
                    {{ csrf_field() }}

                        Nombre actividad
                        <input type="text" class="form-control" required name="activityName" value="{{$activity->activityName}}">

                    <br><br>
                    Prioridad
                    <select class="form-control" name="idPriority">
                    @foreach($priorities as $priority)
                    @if($priority->idPriority == $activity->idPriority)
                    <option selected value='{{ $priority->idPriority }}'>{{ $priority->priorityName }}</option>
                    @else
                        <option value='{{ $priority->idPriority }}'>{{ $priority->priorityName }}</option>
                    @endif
                    @endforeach
                    </select>
                    <br><br>
                    Subarea
                    <select class="form-control" name="idSubarea">
                        @foreach($subareas as $subarea)
                        @if($subarea->idSubarea == $activity->idSubarea)
                        <option selected value='{{ $subarea->idSubarea }}'>{{ $subarea->subareaName }}</option>
                        @else
                            <option value='{{ $subarea->idSubarea }}'>{{ $priority->subareaName }}</option>
                        @endif
                        @endforeach
                        </select>
                        <br><br>
                    Descripción de la actividad
                        <input type="text" class="form-control" required name="activityDescription" value="{{$activity->activityDescription}}">

                    <br><br>

                    Días para resolverlo
                        <input type="number" min="1" class="form-control" required name="days" value="{{$activity->days}}">

                    <br><br>

                    <input type="submit" class="btn btn-success" value="Actualizar">
                    @if(auth()->user()->isAdministrator())
                    <a href="{{route('administrator.activity.index',['subarea'=>$subarea])}}" class="btn btn-info">Regresar</a>
                    @else
                    <a href="{{route('coordinator.activity.index',['subarea'=>$subarea])}}" class="btn btn-info">Regresar</a>
                    @endif
                    <br>
                    <br>
                </form>
            </div>
        </div>

@endsection
