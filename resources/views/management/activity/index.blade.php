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
                <form action="{{route('administrator.activity.create',['subarea'=>$subarea])}}" method="POST">
                {{ csrf_field() }}
                    Nombre de la actividad
                    <input type="text" class="form-control" required name="activityName">

                <br><br>
                    Descripción
                    <input type="text" class="form-control" required name="lastname">
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
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($activities as $activity)
                        <tr>
                            <td>{{$activity->idActivity}}</td>
                            <td>{{ $activity->activityName}}</td>
                            <td>
                                <a href="{{route('administrator.activity.show',['subarea'=>$subarea,'activity'=>$activity])}}" class="btn
                                btn-warning btn-sm">Editar</a>
                            </td>
                            <td>
                                <form action="{{route('administrator.activity.destroy',['subarea'=>$subarea,'activity'=>$activity])}}"
                                      method="POST" class="d-inline">
                                    {{ csrf_field() }}
                                    <input type="submit" onclick="return confirm('¿Seguro que desa borrar?');" class="btn btn-danger btn-sm" value="Eliminar">
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
