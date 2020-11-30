@extends('layouts.main')

@section('title', 'Asignaciones')

@section('icon_title')
<i class="fas fa-tasks"></i>

@endsection


@section('content')
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <div class="row">
        <div class="col-sm-4">
                <h4 class="text-center alert alert-info ">Agregar agente para {{$activity->activityName}}</h4>
                <form action="{{route('administrator.assignment.store.agent',['activity'=>$activity])}}" method="POST">
                {{ csrf_field() }}
                   <select class="form-control" name="idAgent">
                   <option value="">Escoge un agente para {{$activity->activityName}}</option>
                   @foreach($agents as $agent)
                   <option value="{{$agent->idUser}}">{{$agent->name}}</option>
                   @endforeach
                    </select>
                   
                <br><br>
                <input type="submit" class="btn btn-success" value="Agregar">
                @if(auth()->user()->isAdministrator())
                <a href="{{route('administrator.activity.index',['subarea'=>$activity->subarea])}}" class="btn btn-info">Regresar</a>
                @else
                <a href="{{route('coordinator.activity.index',['subarea'=>$activity->subarea])}}" class="btn btn-info">Regresar</a>
                @endif
                <br>
                <br>
            </form>
        </div>

        <div class="col-sm-7 offset-1">
                <h4 class="text-center aler alert-info">Agentes asignados para {{$activity->activityName}}</h4>
                @if(count($assignments)>0)
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
                    @foreach ($assignments as $assignment)
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
                                <form action="{{route('administrator.assignment.destroy', ['assignment'=>$assignment,'activity'=>$activity])}}"
                                      method="POST" class="d-inline">
                                    {{ csrf_field() }}
                                    <input type="submit" onclick="return confirm('¿Seguro que desea eliminar asignación?');" class="btn btn-danger btn-sm" value="X">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            {{$assignments->render()}}
            @else
            <h4 class="text-center aler alert-warning"> No hay agentes para {{$activity->activityName}}</h4>
            @endif
        </div>

@endsection
@if(session()->has('process_result'))
@section('scripts')
        <script>
        $(function(){
           toastr.{{session('process_result')['status']}}({{session
            ('process_result')['content']}}')
        });
        </script>
@endsection
@endif