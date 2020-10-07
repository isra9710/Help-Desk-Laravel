@extends('layouts.main')

@section('title', 'Departamentos')

@section('icon_title')
<i class="far fa-building"></i>
@endsection


@section('content')
        <div class="row">
            <div class="col-sm-8 offset-2">
                <h4 class="text-center alert alert-info ">Editar departamento</h4>
                <form action="{{route('administrator.department.update',['department'=>$department])}}" method="POST">
                    {{ csrf_field() }}

                        Nombre del departamento
                        <input type="text" class="form-control" required name="departmentName" value="{{$department->departmentName}}">

                    <br><br>

                        Descripción
                        <input type="text" class="form-control" required name="departmentDescription" value="{{$department->description}}">
                    <br><br>

                    <input type="submit" class="btn btn-success" value="Actualizar">
                    <a href="{{route('administrator.department.index')}}" class="btn btn-info">Regresar</a>
                    <br>
                    <br>
                </form>
            </div>

@endsection
