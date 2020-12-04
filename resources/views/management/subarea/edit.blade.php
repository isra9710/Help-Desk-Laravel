@extends('layouts.main')

@section('title', 'Subáreas')

@section('icon_title')
<i class="fas fa-monument"></i>
@endsection


@section('content')
        <div class="row">
            <div class="col-sm-8 offset-2">
            <h4 class="text-center alert alert-info ">Editar subarea de {{$department->departmentName}}</h4>
            @if(auth()->user()->isAdministrator())
            <form action="{{route('administrator.subarea.update', ['subarea'=>$subarea,'department'=>$department])}}" method="POST">
            @else
            <form action="{{route('cordinator.subarea.update', ['subarea'=>$subarea,'department'=>$department])}}" method="POST">
            @endif
                
                    {{ csrf_field() }}

                        Nombre de subárea
                        <input type="text" class="form-control" required name="subareaName" value="{{$subarea->subareaName}}">

                    <br><br>

                        Descripción
                        <input type="text" class="form-control" required name="subareaDescription" value="{{$subarea->subareaDescription}}">
                    <br><br>

                    <input type="submit" class="btn btn-success" value="Actualizar">
                    
                    <a href="{{ URL::previous() }}" class="btn btn-info">Regresar</a>
                    <br>
                    <br>
                </form>
            </div>

@endsection
