@extends('layouts.main')

@section('title', 'Subáreas para '.$department->departmentName)

@section('icon_title')
<i class="fas fa-monument"></i>

@endsection


@section('content')
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

   
    <div class="row">
        <div class="col-sm-4">
                <h4 class="text-center alert alert-info ">Agregar nueva subárea</h4>
                @if(auth()->user()->isAdministrator())
                <form action="{{route('administrator.subarea.store',['department'=>$department])}}" method="POST">
                @else
                <form action="{{route('coordinator.subarea.store',['department'=>$department])}}" method="POST">
                @endif 
                {{ csrf_field() }}

                    Nombre
                    <input type="text" class="form-control" required name="subareaName">

                <br><br>

                    Descripción
                    <input type="text" class="form-control" required name="subareaDescription">
                <br><br>
                <input type="submit" class="btn btn-success" value="Agregar">
                <br>
                <br>
            </form>
        </div>

        <div class="col-sm-7 offset-1">
                <h4 class="text-center aler alert-info">Subáreas Registradas</h4>
                @if(count($subareas)>0)
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th scope="col">Nombre de subárea </th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Acciones</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($subareas as $subarea)
                        <tr>
                            <td>{{$subarea->idSubarea}}</td>
                            <td>{{ $subarea->subareaName}}</td>
                            <td>{{$subarea->subareaDescription}}</td>
                            <td>
                                @if(auth()->user()->isAdministrator())
                                    <a href="{{route('administrator.subarea.edit', ['department'=>$department,'subarea'=>$subarea])}}" class="btn
                                    btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                @else
                                    @if($subarea->active)
                                        <a href="{{route('coordinator.subarea.edit', ['department'=>$department,'subarea'=>$subarea])}}" class="btn
                                            btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    @endif
                                @endif
                            @if(auth()->user()->isAdministrator())
                                <form action="{{route('administrator.subarea.destroy', ['department'=>$department,'subarea'=>$subarea])}}"
                                      method="POST" class="d-inline">
                                    {{ csrf_field() }}
                                    @if($subarea->active)
                                    <input type="submit" onclick="return confirm('¿Seguro que desa desactivar?');" class="btn btn-danger btn-sm" value="X">
                                    @else
                                    <input type="submit" onclick="return confirm('¿Seguro que desea activar?');"  class="btn btn-success"   value="✓">
                                    @endif
                                </form>
                            @else
                                @if($subarea->active)
                                    <form action="{{route('coordinator.subarea.destroy', ['department'=>$department,'subarea'=>$subarea])}}"
                                            method="POST" class="d-inline">
                                            <input type="submit" onclick="return confirm('¿Seguro que desea desactivar?');"  class="btn btn-danger btn-sm"   value="X">
                                            
                                        </form>
                                @endif
                            @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            {{$subareas->render()}}
            @else
            <h4 class="text-center aler alert-warning"> No hay registro de subáreas para {{$department->departmentName}}</h4>
            @endif
        </div>

@endsection
