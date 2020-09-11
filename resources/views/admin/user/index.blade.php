@extends('layouts.app')

@section('title', 'Empleados')

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
            <h4 class="text-center alert alert-info ">Agregar nuevo empleado</h4>
            <form action="{{route('admin.user.createE')}}" method="POST">
                {{ csrf_field() }}
                <label>
                    Nombre
                    <input type="text" class="form-control" required name="firstname">
                </label>
                <br><br>
                <label>
                    Apellidos
                    <input type="text" class="form-control" required name="lastname">
                </label><br><br>
                <label>
                    Correo electronico
                    <input type="email" class="form-control" required name="email">
                </label><br><br>
                <label>
                    Nombre de usuario
                    <input type="text" class="form-control" required name="username">
                </label><br><br>
                <label>
                    Contraseña
                    <input type="password" class="form-control" required name="password">
                </label><br><br>
                <input type="submit" class="btn btn-success" value="Agregar">
                <br>
                <br>
            </form>
        </div>

        <div class="col-sm-7 offset-1">
            <h4 class="text-center aler alert-info">Empleados Registrados</h4>
            @if(count($users)>0)
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Nombre </th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Correo electronico</th>
                        <th scope="col">Nombre de usuario</th>
                        <th scope="col">Tipo de usuario</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>

                            <td>{{ $user->firstname}}</td>
                            <td>{{$user->lastname }}</td>
                            <td>{{$user->email }}</td>
                            <td>{{$user->username}}</td>
                            <td>{{$user->idTypeU}}</td>
                            <td>
                                <a href="{{route('admin.user.showE', $user->idUser)}}" class="btn
                                btn-warning btn-sm">Editar</a>
                            </td>
                            <td>
                                <form action="{{route('admin.user.destroyE', $user->idUser)}}"
                                      method="GET" class="d-inline">
                                    {{ csrf_field() }}
                                    <input type="submit" onclick="return confirm('¿Seguro que desa borrar?');" class="btn btn-danger btn-sm" value="Eliminar">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            {{$users->render()}}
            @else
                <h4 class="text-center aler alert-warning"> No hay registro de empleados</h4>
            @endif
        </div>

@endsection
