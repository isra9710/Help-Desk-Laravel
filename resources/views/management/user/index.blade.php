@extends('layouts.main')
@if($role==5)
    @section('title', 'Empleados')
@else
    @section('title', 'Tecnicos')
@endif

@section('icon_title')
<i class="fa fa-fw fa-user"></i>
@endsection


@section('content')
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

   <!-- <div class="container mt-5">
        <h2 class="text-center alert alert-danger">Gestión Empleados</h2>
    </div>-->
    <div class="row">
        <div class="col-sm-4">
            @if($role==5)
                <h4 class="text-center alert alert-info ">Agregar nuevo empleado</h4>
            @else
                <h4 class="text-center alert alert-info ">Agregar nuevo tecnico</h4>
            @endif
            @if(auth()->user()->isAdministrator())
                <form action="{{route('administrator.user.create')}}" method="POST">
            @else
                <form action="{{route('coordinator.user.create')}}" method="POST">   
            @endif
                {{ csrf_field() }}

                    Nombre
                    <input type="text" class="form-control" required name="name">

                <br><br>

                    Correo electronico
                    <input type="email" class="form-control" required name="email">
                <br><br>

                    Número de empleado
                    <input type="text" class="form-control" required name="username">
                <br><br>
                    Extensión telefónica
                    <input type="text" class="form-control" required name="extension">
                    <br><br>
                    Contraseña
                    <input type="password" class="form-control" required name="password">
                <br><br>
                <input type="submit" class="btn btn-success" value="Agregar">
                <br>
                <br>
                <input type="hidden" value="{{$role}}" name="type">
            </form>
        </div>

        <div class="col-sm-7 offset-1">
            @if($role==5)
                <h4 class="text-center aler alert-info">Empleados Registrados</h4>
            @else
                <h4 class="text-center aler alert-info">Tecnicos Registrados</h4>
            @endif
                @if(count($users)>0)
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th scope="col">Nombre </th>
                        <th scope="col">Correo electronico</th>
                        <th scope="col">Número de empleado</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{$user->idUser}}</td>
                            <td>{{ $user->name}}</td>
                            <td>{{$user->email }}</td>
                            <td>{{$user->username}}</td>
                            <td>
                                @if(auth()->user()->isAdministrator())
                                    <a href="{{route('administrator.user.show', $user->idUser)}}" class="btn
                                        btn-warning btn-sm">Editar</a>
                                @else
                                    <a href="{{route('coordinator.user.show', $user->idUser)}}" class="btn
                                        btn-warning btn-sm">Editar</a>   
                                @endif
                            </td>
                            <td>
                                @if(auth()->user()->isAdministrator())
                                    <form action="{{route('administrator.user.destroy', $user->idUser)}}" method="POST">
                                @else
                                    <form action="{{route('coordinator.user.destroy', $user->idUser)}}" method="POST">   
                                @endif
                                {{ csrf_field() }}
                                    <input type="submit" onclick="return confirm('¿Seguro que desa borrar?');" class="btn btn-danger btn-sm" value="Eliminar">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            {{$users->render()}}
            @elseif($role==5)
                <h4 class="text-center aler alert-warning"> No hay registro de empleados</h4>
            @else
                <h4 class="text-center aler alert-warning"> No hay registro de técnicos</h4>
            @endif
        </div>

@endsection
