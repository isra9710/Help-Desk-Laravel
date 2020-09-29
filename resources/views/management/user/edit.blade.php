@extends('layouts.main')

@section('title', 'Empleados')

@section('icon_title')
    <i class="fa fa-fw fa-user"></i>
@endsection


@section('content')
        <div class="row">
            <div class="col-sm-8 offset-2">
                <h4 class="text-center alert alert-info ">Editar empleado</h4>
                @if(auth()->user()->isAdministrator())
                    <form action="{{route('administrator.user.update', $user->idUser)}}" method="POST">
                @else
                    <form action="{{route('coordinator.user.update', $user->idUser)}}" method="POST">
                @endif    
                        {{ csrf_field() }}

                        Nombre
                        <input type="text" class="form-control" required name="firstname" value="{{$user->firstname}}">

                    <br><br>

                        Apellidos
                        <input type="text" class="form-control" required name="lastname" value="{{$user->lastname}}">
                    <br><br>

                        Correo electronico
                        <input type="email" class="form-control" required name="email" value="{{$user->email}}">
                    <br><br>

                    Número de empleado
                        <input type="text" class="form-control" required name="username" value="{{$user->username}}">
                    <br><br>
                    <input type="submit" class="btn btn-success" value="Actualizar">
                    @if(auth()->user()->isAdministrator())
                        <a href="{{route('administrator.user.index',$user->idRole)}}" class="btn btn-info">Regresar</a>
                    @else
                    <a href="{{route('coordinator.user.index',$user->idRole)}}" class="btn btn-info">Regresar</a>
                    @endif
                    <br>
                    <br>
                </form>
            </div>

@endsection
