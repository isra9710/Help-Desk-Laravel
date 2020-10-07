@extends('layouts.main')

@section('title', 'Actividades')

@section('icon_title')
    <i class="fas fa-clipboard"></i>
@endsection


@section('content')
        <div class="row">
            <div class="col-sm-8 offset-2">
                <h4 class="text-center alert alert-info ">Editar Actividad</h4>
                <form action="{{route('administrator.activity.update',['subarea'=>$subarea,'activity'=>$activity])}}" method="POST">
                    {{ csrf_field() }}

                        Nombre actividad
                        <input type="text" class="form-control" required name="activityName" value="{{$activity->activityName}}">

                    <br><br>

                        Apellidos
                        <input type="text" class="form-control" required name="lastname" value="{{$activity->description}}">
                    <br><br>

                    <input type="submit" class="btn btn-success" value="Actualizar">
                    <a href="{{route('administrator.activity.index',['subarea'=>$subarea])}}" class="btn btn-info">Regresar</a>
                    <br>
                    <br>
                </form>
            </div>

@endsection
