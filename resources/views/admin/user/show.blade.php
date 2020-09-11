@extends('layouts.app')

@section('title', 'Empleados')

@section('icon_title')
    <i class="fa fa-fw fa-user"></i>
@endsection


@section('content')
        <div class="row">
            <div class="col-sm-8 offset-2">
                <h4 class="text-center alert alert-info ">Editar empleado</h4>
                <form action="{{route('admin.user.updateE', $user->idUser)}}" method="POST">
                    {{ csrf_field() }}
                    <input type="text" value="{{$user->idUser}}" name="idUser">
                    <label>
                        Nombre
                        <input type="text" class="form-control" required name="firstname" value="{{$user->firstname}}">
                    </label>
                    <br><br>
                    <label>
                        Apellidos
                        <input type="text" class="form-control" required name="lastname" value="{{$user->lastname}}">
                    </label><br><br>
                    <label>
                        Correo electronico
                        <input type="email" class="form-control" required name="email" value="{{$user->email}}">
                    </label><br><br>
                    <label>
                        Nombre de usuario
                        <input type="text" class="form-control" required name="username" value="{{$user->username}}">
                    </label><br><br>
                    <input type="submit" class="btn btn-success" value="Actualizar">
                    <a href="{{route('admin.user.indexE')}}" class="btn btn-info">Regresar</a>
                    <br>
                    <br>
                </form>
            </div>

@endsection
