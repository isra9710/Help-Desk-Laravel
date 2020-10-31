@extends('layouts.main')

@section('title', 'Empleados')

@section('icon_title')
<i class="fas fa-user-edit"></i>
@endsection


@section('content')
        <div class="row">
            <div class="col-sm-8 offset-2">
                <h4 class="text-center alert alert-info ">Detalles de empleado</h4>
                <form>
                    ID
                        <input type="text" class="form-control" readonly name="username" value="{{$user->idUser}}">
                    <br><br>
                       
                        Número de empleado
                        <input type="text" class="form-control" readonly name="username" value="{{$user->username}}">
                    <br><br>
                        
                        Nombre
                        <input type="text" class="form-control" readonly name="name" value="{{$user->name}}">

                    <br><br>


                        Correo electronico
                        <input type="email" class="form-control" readonly name="email" value="{{$user->email}}">
                    <br><br>
                    Extensión
                        <input type="text" class="form-control" readonly name="extension" value="{{$user->extension}}">

                    <br><br>
                    @if(!($user->idRole==5))

                    Departamento
                        <input type="text" class="form-control" readonly name="department" value="{{$user->department->departmentName}}">
                       
                    <br><br>
                    @endif
                    @if(auth()->user()->isAdministrator())
                        <a href="{{route('administrator.user.index',[$user->idRole, $user->idDepartment])}}" class="btn btn-info">Regresar</a>
                    @elseif(auth()->user()->isCoordinator())
                        <a href="{{route('coordinator.user.index',[$user->idRole,$user->idDepartment])}}" class="btn btn-info">Regresar</a>
                    @else
                        <a href="{{route('assistant.user.index',[$user->idRole,$user->idDepartment])}}" class="btn btn-info">Regresar</a>
                    @endif
                    <br>
                    <br>
                </form>
            </div>

@endsection
