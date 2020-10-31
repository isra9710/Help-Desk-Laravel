@extends('layouts.main')
@if($idRole==2)
    @section('title', 'Coordinadores')

@elseif($idRole==3)
    @section('title', 'Asistentes')
@elseif($idRole==4)
    @section('title', 'Agentes')
@elseif($idRole==5)
    @section('title','Usuarios')
@elseif($idRole==6)
    @section('title', 'Invitados')
@endif

@section('icon_title')
<i class="fa fa-fw fa-user"></i>
@endsection


@section('content')
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!--<div class="container mt-5">
        <h2 class="text-center alert alert-danger">Gestión Empleados</h2>
    </div>-->
    <div class="row">
        <div class="col-sm-4">
            @if($idRole==2)
                <h4 class="text-center alert alert-info ">Agregar nuevo coordinador</h4>
            @elseif($idRole==3)
                <h4 class="text-center alert alert-info ">Agregar nuevo  asistente</h4>
            @elseif($idRole==4)
                <h4 class="text-center alert alert-info ">Agregar nuevo agente</h4>
            @else
                <h4 class="text-center alert alert-info ">Agregar nuevo usuario</h4>
            @endif
            @if(auth()->user()->isAdministrator())
                <form action="{{route('administrator.user.store')}}" method="POST">
            @elseif(auth()->user()->isCoordinator())
                <form action="{{route('coordinator.user.store')}}" method="POST">
            @else
                <form action="{{route('assistant.user.store')}}" method="POST">
            @endif
                {{ csrf_field() }}
                @if($idRole==2 || $idRole==3 || $idRole==4)
                    <input type="hidden" value="{{$idDepartment}}" name="idDepartment">
                @endif
                    Nombre
                    <input type="text" class="form-control" required name="name">

                <br><br>
                Número de empleado
                <input type="text" class="form-control" required name="username">
                <br><br>

                    Correo electronico
                    <input type="email" class="form-control" required name="email">
                <br><br>


                    Extensión telefónica
                    <input type="text" class="form-control" required name="extension">
                    <br><br>
                    Contraseña
                    <input type="password" class="form-control" required name="password">

                    @if($idRole==4)

                    @endif
                <br><br>
                <input type="submit" class="btn btn-success" value="Agregar">
                <br>
                <br>
                <input type="hidden" value="{{$idRole}}" name="idRole">
            </form>
        </div>


        <div class="col-sm-7 offset-1">



            @if($idRole==2)
                 <h4 class="text-center alert alert-info ">Coordinadores registrados</h4>
            @elseif($idRole==3)
                <h4 class="text-center alert alert-info ">Asistentes registrados</h4>
            @elseif($idRole==4)
                <h4 class="text-center alert alert-info ">Agentes registrados</h4>
            @else
                <h4 class="text-center alert alert-info ">Usuarios registrados</h4>
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
                            <td>{{$user->name}}</td>
                            <td>{{$user->email }}</td>
                            <td>{{$user->username}}</td>
                            <td>
                                @if(auth()->user()->isAdministrator())
                                <a href="{{route('administrator.user.edite',['user'=>$user])}}" class="btn
                                        btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                       
                                @elseif(auth()->user()->isCoordinator())
                                    <a href="{{route('coordinator.user.edite', ['user'=>$user])}}" class="btn
                                        btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                @else
                                <a href="{{route('assistant.user.edite', ['user'=>$user])}}" class="btn
                                        btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                @endif
                            </td>
                            <td>
                                @if(auth()->user()->isAdministrator())
                                <form action="{{route('administrator.user.destroy',['user'=>$user])}}" method="POST">
                                    @if($user->active)
                                    <input type="submit" onclick="return confirm('¿Seguro que desa desactivar usuario?');" class="btn btn-danger btn-sm" value="X">
                                    @else
                                     <input type="submit" onclick="return confirm('¿Seguro que desa reactivar usuario?');" class="btn btn-success"   value="✓">
                                     @endif
                                     </form>
                                @elseif(auth()->user()->isCoordinator())
                                    <form action="{{route('coordinator.user.destroy', ['user'=>$user])}}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="submit" onclick="return confirm('¿Seguro que desa desactivar usuario?');" class="btn btn-danger btn-sm" value="X">
                                     </form>
                                @else
                                    <form action="{{route('assistant.user.destroy', ['user'=>$user])}}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="submit" onclick="return confirm('¿Seguro que desa desactivar usuario?');" class="btn btn-danger btn-sm" value="X">
                                     </form>
                                @endif
                               
                            </td>
                            <td>
                            @if(auth()->user()->isAdministrator())
                                <a href="{{route('administrator.user.details',['user'=>$user])}}" class="btn
                                        btn-warning btn-sm"><i class="fas fa-eye"></i></a>
                                       
                                @elseif(auth()->user()->isCoordinator())
                                    <a href="{{route('coordinator.user.details', ['user'=>$user])}}" class="btn
                                        btn-warning btn-sm"><i class="fas fa-eye"></i></a>
                                @else
                                <a href="{{route('assistant.user.details', ['user'=>$user])}}" class="btn
                                        btn-warning btn-sm"><i class="fas fa-eye"></i></a>
                                @endif
                            
                            </td>
                            <td>
                            @if(auth()->user()->isAdministrator())
                                <a href="{{route('administrator.user.activities',['user'=>$user])}}" class="btn
                                        btn-warning btn-sm"><i class="fas fa-server"></i></a>
                                       
                                @elseif(auth()->user()->isCoordinator())
                                    <a href="{{route('coordinator.user.activities', ['user'=>$user])}}" class="btn
                                        btn-warning btn-sm"><i class="fas fa-server"></i></a>
                                @else
                                <a href="{{route('assistant.user.activities', ['user'=>$user])}}" class="btn
                                        btn-warning btn-sm"><i class="fas fa-server"></i>></i></a>
                                @endif
                            
                            </td>
                            @if(auth()->user()->isAssistant())
                            <td>
                            @if($user->status)
                                <a href="{{route('assistant.user.status', ['user'=>$user])}}" class="btn
                                        btn-warning btn-sm"><i class="fas fa-history"></i></a>
                            @else
                            @endif
                            </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            {{$users->render()}}
            @elseif($idRole==2)
                <h4 class="text-center aler alert-warning"> No hay registro de coordinadores</h4>
            @elseif($idRole==3)
                <h4 class="text-center aler alert-warning"> No hay registro de asistentes</h4>
            @elseif($idRole==4)
                <h4 class="text-center aler alert-warning"> No hay registro de agentes</h4>
            @else
                <h4 class="text-center aler alert-warning"> No hay registro de usuarios</h4>
            @endif
        </div>

@endsection
