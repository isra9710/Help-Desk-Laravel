@extends('layouts.main')

@section('title', 'Empleados')

@section('icon_title')
<i class="fas fa-user-edit"></i>
@endsection


@section('content')
        <div class="row">
            <div class="col-sm-8 offset-2">
                <h4 class="text-center alert alert-info ">Editar empleado</h4>
                @if(auth()->user()->isAdministrator())
                    <form action="{{route('administrator.user.update', ['user'=>$user])}}" method="POST">
                @elseif(auth()->user()->isAdministrator())
                    <form action="{{route('coordinator.user.update', ['user'=>$user])}}" method="POST">
                @else
                    <form action="{{route('assistant.user.update',['user'=>$user])}}" method="POST">
                @endif    
                        {{ csrf_field() }}

                        Número de empleado
                        <input type="text" class="form-control" required name="username" value="{{$user->username}}">
                    <br><br>
                        
                        Nombre
                        <input type="text" class="form-control" required name="name" value="{{$user->name}}">

                    <br><br>


                        Correo electronico
                        <input type="email" class="form-control" required name="email" value="{{$user->email}}">
                    <br><br>
                    <input type="submit" class="btn btn-success" value="Actualizar">
                    @if(auth()->user()->isAdministrator())
                        <a href="{{route('administrator.user.index',[$user->idRole, $user->idDepartment])}}" class="btn btn-info">Regresar</a>
                    @else
                    <a href="{{route('coordinator.user.index',[$user->idRole,$user->idDepartment])}}" class="btn btn-info">Regresar</a>
                    @endif
                    <br>
                    <br>
                </form>
            </div>

@endsection
