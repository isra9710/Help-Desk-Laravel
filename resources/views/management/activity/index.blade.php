@extends('layouts.main')
@section('title', 'Actividades')


@section('icon_title')
<i class="fas fa-clipboard-list"></i>
@endsection


@section('content')
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

   <!-- <div class="container mt-5">
        <h2 class="text-center alert alert-danger">Gestión Empleados</h2>
    </div>-->
    <div class="row">
        <div class="col-sm-4">
        <h4 class="text-center alert alert-info ">Agregar nueva actividad para  {{$subarea->subareaName}}</h4>
                <form action="{{route('administrator.activity.store',['subarea'=>$subarea])}}" method="POST">
                {{ csrf_field() }}
                    Nombre de la actividad
                    <input type="text" class="form-control" required name="activityName">

                <br><br>
                    Descripción
                    <input type="text" class="form-control" required name="lastname">
                    <br><br>
                    Días asignados para la actividad
                    <input type="number" min="1" class="form-control" required name="lastname">
                    <br><br>
             
                <input type="submit" class="btn btn-success" value="Agregar">
                <br>
                <br>
                <input type="hidden" value="{{$subarea->idSubarea}}" name="type">
            </form>
        </div>

        <div class="col-sm-7 offset-1">
   
        <h4 class="text-center aler alert-info">Actividades Registradas de {{$subarea->subareaName}}</h4>
                      @if(count($activities)>0)
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th scope="col">Nombre de actividad</th>
                        <th scope="col">Prioridad</th>
                        <th scope="col">Descripción</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($activities as $activity)
                        <tr>
                            <td>{{$activity->idActivity}}</td>
                            <td>{{ $activity->activityName}}</td>
                            <td>{{ $activity->priority->priorityName}}</td>
                            <td>{{ $activity->activityDescription}}</td>
                            <td>
                                @if(auth()->user()->isAdministrator())
                                <a href="{{route('administrator.activity.edite',['subarea'=>$subarea,'activity'=>$activity])}}" class="btn
                                btn-warning btn-sm">Editar</a>
                                @else
                                <a href="{{route('coordinator.activity.edite',['subarea'=>$subarea,'activity'=>$activity])}}" class="btn
                                    btn-warning btn-sm">Editar</a>
                                @endif
                            </td>
                            <td>
                                @if(auth()->user()->isAdministrator())
                                <form action="{{route('administrator.activity.destroy',['subarea'=>$subarea,'activity'=>$activity])}}"
                                      method="POST" class="d-inline">
                                @else
                                <form action="{{route('coordinator.activity.destroy',['subarea'=>$subarea,'activity'=>$activity])}}"
                                    method="POST" class="d-inline">    
                                      {{ csrf_field() }}
                                @endif
                                    <input type="submit" onclick="return confirm('¿Seguro que desea desactivar actividad?');" class="btn btn-danger btn-sm" value="Desactivar">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            {{$activities->render()}}
            @else
            <h4 class="text-center aler alert-warning"> No hay registro de actividades para {{$subarea->subareaName}}</h4>
            @endif
        </div>

@endsection
