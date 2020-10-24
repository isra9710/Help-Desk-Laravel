@extends('layouts.main')

@section('title', 'Subáreas')

@section('icon_title')
<i class="fas fa-monument"></i>

@endsection


@section('content')
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

   <!-- <div class="container mt-5">
        <h2 class="text-center alert alert-danger">Gestión Empleados</h2>
    </div>-->
    <div class="row">
        <div class="col-sm-4">
                <h4 class="text-center alert alert-info ">Agregar nueva subárea para {{$department->departmentName}}</h4>
                <form action="{{route('administrator.subarea.create',['department'=>$department])}}" method="POST">
                {{ csrf_field() }}

                    Nombre
                    <input type="text" class="form-control" required name="subareaName">

                <br><br>

                    Descripción
                    <input type="text" class="form-control" required name="lastname">
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
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($subareas as $subarea)
                        <tr>
                            <td>{{$subarea->idSubarea}}</td>
                            <td>{{ $subarea->subareaName}}</td>
                            <td>
                                <a href="{{route('administrator.subarea.show', ['department'=>$department,'subarea'=>$subarea])}}" class="btn
                                btn-warning btn-sm">Editar</a>
                            </td>
                            <td>
                                <form action="{{route('administrator.subarea.destroy', ['department'=>$department,'subarea'=>$subarea])}}"
                                      method="POST" class="d-inline">
                                    {{ csrf_field() }}
                                    <input type="submit" onclick="return confirm('¿Seguro que desa desactivar?');" class="btn btn-danger btn-sm" value="Desactivar">
                                </form>
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
