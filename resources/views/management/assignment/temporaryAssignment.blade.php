@extends('layouts.main')

@section('title', 'Asignación Temporal')

@section('icon_title')
<i class="fas fa-tasks"></i>

@endsection


@section('content')
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <div class="row">
        <div class="col-sm-4">
                <h4 class="text-center alert alert-info ">Agregar agente temporal para cubrir a {{$user->name}}</h4>
                @if(auth()->user()->isAdministrator())
                <form action="{{route('administrator.assignment.temporary.activity',['all'=>FALSE,'agent'=>$user])}}" method="POST"> 
                {{ csrf_field() }}
                @else
                <form action="{{route('assistant.assignment.temporary.activity',['all'=>FALSE,'agent'=>$user])}}" method="POST"> 
                 
                {{ csrf_field() }}
                @endif
                   <select class="form-control" name="idAgent">
                   <option value="">Escoge un agente </option>
                   @foreach($agents as $agent)
                   <option value="{{$agent->idUser}}">{{$agent->name}}</option>
                   @endforeach
                    </select>
                    <br><br>
                    <select class="form-control" name="idActivity">
                   <option value="">Escoge una actividad </option>
                   @foreach($assignments as $assignment)
                   <option value="{{$assignment->activity->idActivity}}">{{$assignment->activity->activityName}}</option>
                   @endforeach
                    </select>
                <br><br>
                <input type="submit" class="btn btn-success" value="Agregar actividad">
                <br><br>
            </form>
            @if(auth()->user()->isAdministrator())
                <form action="{{route('administrator.assignment.temporary.all',['all'=>TRUE,'agent'=>$user])}}" method="POST"> 
                {{ csrf_field() }}
                <select class="form-control" name="idAgent">
                   <option value="">Escoge un agente </option>
                   @foreach($agents as $agent)
                   <option value="{{$agent->idUser}}">{{$agent->name}}</option>
                   @endforeach
                    </select>
                    <br>
                    <input type="submit" class="btn btn-success" value="Agregar todas la actividades de manera temporal">
                </form>
                <br>
                @else
                <form action="{{route('assistant.assignment.temporary.all',['agent'=>$user])}}" method="POST"> 
                {{ csrf_field() }}
                <select class="form-control" name="idAgent">
                   <option value="">Escoge un agente </option>
                   @foreach($agents as $agent)
                   <option value="{{$agent->idUser}}">{{$agent->name}}</option>
                   @endforeach
                    </select>
                    <br><br>
                <input type="submit" class="btn btn-success" value="Agregar todas la actividades de manera temporal">
                </form>
                <br><br>
                @endif
                @if(auth()->user()->isAdministrator())
                <a href="{{route('administrator.user.index',[$user->idRole,$user->idDepartment])}}" class="btn btn-info">Regresar</a>
                @else
                <a href="{{route('assistant.user.index',[$user->idRole,$user->idDepartment])}}" class="btn btn-info">Regresar</a>
                @endif
        </div>

        <div class="col-sm-7 offset-1">
                <h4 class="text-center aler alert-info">Agentes asignados para cubrir a {{$user->name}}</h4>
                @if(count($assignments1)>0)
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th scope="col">ID Agente</th>
                        <th scope ="col">Nombre</th>
                        <th scope="col">Departamento</th>
                        <th scope="col">Subarea</th>
                        <th scope="col">Actividad</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Activo</th>
                        <th scope="col">Temporal</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($assignments1 as $assignment)
                        <tr>
                            <td>{{$assignment->idAssignment}}</td>
                            <td>{{ $assignment->idUser}}</td>
                            <td>{{$assignment->user->name}}</td>
                            <td>{{ $assignment->activity->subarea->department->departmentName}}</td>
                            <td>{{ $assignment->activity->subarea->subareaName}}</td>
                            <td>{{ $assignment->activity->activityName}}</td>
                            @if($assignment->user->status)
                            <td>Disponible</td>
                            @else
                            <td>No disponible</td>
                            @endif
                            @if($assignment->user->active)
                            <td>Sí</td>
                            @else
                            <td>No</td>
                            @endif
                            @if($assignment->temporary)
                                <td>Sí</td>
                            @else
                                <td>No</td>
                            @endif
                            <td>
                                <form action=""
                                      method="POST" class="d-inline">
                                    {{ csrf_field() }}
                                    <input type="submit" onclick="return confirm('¿Seguro que desea eliminar asignación?');" class="btn btn-danger btn-sm" value="X">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            {{$assignments1->render()}}
            @else
            <h4 class="text-center aler alert-warning"> No hay agentes temporales para cubrir a {{$user->name}}</h4>
            @endif
        </div>

@endsection
