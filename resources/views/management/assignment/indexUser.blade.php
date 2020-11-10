@extends('layouts.main')

@section('title', 'Asignaciones')

@section('icon_title')
<i class="fas fa-tasks"></i>

@endsection


@section('content')
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <div class="row">
        <div class="col-sm-4">
                <h4 class="text-center alert alert-info ">Agregar nuevo servicio para {{$user->name}}</h4>
                <form action="{{route('administrator.assignment.store.activity',['user'=>$user])}}" method="POST">
                {{ csrf_field() }}

                   <select class="form-control" name="idActivity">
                   <option value="">Escoge una nueva actividad para el agente</option>
                   @foreach($activities as $activity)
                   <option value="{{$activity->idActivity}}">{{$activity->activityName}}</option>
                   @endforeach
                    </select>
                   
                <br><br>
                <input type="submit" class="btn btn-success" value="Agregar">
                @if(auth()->user()->isAdministrator())
                <a href="{{route('administrator.user.index',[$user->idRole, $user->idDepartment])}}" class="btn btn-info">Regresar</a>
                @elseif(auth()->user()->isCoordinator())
                <a href="{{route('coordinator.user.index',[$user->idRole, $user->idDepartment])}}" class="btn btn-info">Regresar</a>
                @else
                <a href="{{route('assistant.user.index',[$user->idRole, $user->idDepartment])}}" class="btn btn-info">Regresar</a>
                @endif
                <br>
                <br>
            </form>
        </div>

        <div class="col-sm-7 offset-1">
                <h4 class="text-center aler alert-info">Actividades asignadas a {{$user->name}}</h4>
                @if(count($userActivities)>0)
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th scope="col">ID Actividad </th>
                        <th scope="col">ID Agente</th>
                        <th scope="col">Departamento</th>
                        <th scope="col">Subarea</th>
                        <th scope="col">Actividad</th>
                        <th scope="col">Temporal</th>
                        <th scope="col">Estado</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($userActivities as $assignment)
                        <tr>
                            <td>{{$assignment->idAssignment}}</td>
                            <td>{{ $assignment->idActivity}}</td>
                            <td>{{ $assignment->idUser}}</td>
                            <td>{{ $assignment->activity->subarea->department->departmentName}}</td>
                            <td>{{ $assignment->activity->subarea->subareaName}}</td>
                            <td>{{ $assignment->activity->activityName}}</td>
                            @if($assignment->temporary)
                                <td>Sí</td>
                            @else
                                <td>No</td>
                            @endif
                            @if($assignment->activity->active)
                                <td>Activo</td>
                            @else
                                <td>Desactivado</td>
                            @endif
                            <td>
                                <form action="{{route('administrator.assignment.destroy', ['assignment'=>$assignment,'user'=>$user])}}"
                                      method="POST" class="d-inline">
                                    {{ csrf_field() }}
                                    <input type="submit" onclick="return confirm('¿Seguro que desea eliminar asignación?');" class="btn btn-danger btn-sm" value="X">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            {{$userActivities->render()}}
            @else
            <h4 class="text-center aler alert-warning"> No hay asignaciones para {{$user->name}}</h4>
            @endif
        </div>

@endsection
