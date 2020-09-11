@extends('layouts.app')

@section('title', 'Empleados')

@section('icon_title')
    <i class="fa fa-fw fa-user"></i>
@endsection


@section('content')
        <div class="row">
            <div class="col-sm-8 offset-2">
                <h4 class="text-center alert alert-info ">Editar empleado</h4>
                <form action="{{route('admin.user.update', $user->idUser)}}" method="POST">
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

                        Nombre de usuario
                        <input type="text" class="form-control" required name="username" value="{{$user->username}}">
                    <br><br>
                    <input type="submit" class="btn btn-success" value="Actualizar">
                    <a href="{{route('admin.user.index',$user->idTypeU)}}" class="btn btn-info">Regresar</a>
                    <br>
                    <br>
                </form>
            </div>

@endsection
