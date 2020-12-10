@extends('layouts.main')
@section('title', 'Departamentos')
 
@section('icon_title')
<i class="far fa-building"></i>
@endsection

@section('content')
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <div class="row">
        <div class="col-sm-4">
                <h4 class="text-center alert alert-info ">Agregar nuevo departamento</h4>

                <form action="{{route('administrator.department.store')}}" method="POST">
                {{ csrf_field() }}

                    Nombre
                    <input type="text" class="form-control" required name="departmentName">

                <br><br>

                    Descripción
                    <input type="text" class="form-control" required name="departmentDescription">
                <br><br>
                <input type="submit" class="btn btn-success" value="Agregar">
                <br>
                <br>
            </form>
        </div>

        <div class="col-sm-7 offset-1">
                <h4 class="text-center aler alert-info">Departamentos Registrados</h4>
                @if(count($departments)>0)
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th scope="col">Nombre </th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Estado</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($departments as $department)
                        <tr>
                            <td>{{$department->idDepartment}}</td>
                            <td>{{ $department->departmentName}}</td>
                            <td>{{$department->departmentDescription}}</td>
                            @if($department->active)
                            <td>Activo</td>
                            @else
                            <td>Desactivado</td>
                            @endif
                            <td>
                                <a href="{{route('administrator.department.edit',$department)}}" class="btn
                                btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            </td>
                            <td>

                                <form action="{{route('administrator.department.destroy', $department)}}"
                                      method="POST" class="d-inline">
                                    {{ csrf_field() }} 
                                    @if($department->active)
                                        <input type="submit" onclick="return confirm('¿Seguro que desea desactivar departamento?');" class="btn btn-danger btn-sm" value="X">
                                    @else
                                    <input type="submit" onclick="return confirm('¿Seguro que desea reactivar departamento?');" class="btn btn-success"   value="✓">
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            {{$departments->render()}}
            @else
                <h4 class="text-center aler alert-warning"> No hay registro de departamentos</h4>
            @endif
        </div>

@endsection
