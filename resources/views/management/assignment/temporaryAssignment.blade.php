@extends('layouts.main')

@section('title', 'Asignación Temporal')

@section('icon_title')
<i class="fas fa-tasks"></i>

@endsection


@section('content')
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <div class="row">
        <div class="col-sm-4">
                <h4 class="text-center alert alert-info ">Agregar agente temporal para {{$subarea->subareaName}}</h4>
                <form>
                   <select class="form-control" name="idAgent">
                   <option value="">Escoge un agente para {{$subarea->subareaName}}</option>
                   @foreach($agents as $agent)
                   <option value="{{$agent->idUser}}">{{$agent->name}}</option>
                   @endforeach
                    </select>
                    <br><br>
                    <select class="form-control" name="idAgent">
                   <option value="">Escoge una actividad </option>
                   @foreach($assignments as $assignment)
                   <option value="{{$assignment->activity->idActivity}}">{{$assignment->activity->activityName}}</option>
                   @endforeach
                    </select>
                <br><br>
                <a href=""  class="btn btn-success">Agregar actividad</a>
                <br><br>
                
                <a href="{{route('administrator.assignment.temporary.activity')}}" class="btn btn-secondary">Agregar subárea de manera temporal</a>
                <a href="{{route('administrator.assignment.temporary.subarea',['subarea'=>$subarea])}}" class="btn btn-info">Regresar</a>
                <br>
                <br>
            </form>
        </div>

        <div class="col-sm-7 offset-1">
                <h4 class="text-center aler alert-info">Agentes asignados para {{$subarea->subareaName}}</h4>
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
            {{$assignments->render()}}
            @else
            <h4 class="text-center aler alert-warning"> No hay agentes temporales para {{$subarea->subareaName}}</h4>
            @endif
        </div>

@endsection