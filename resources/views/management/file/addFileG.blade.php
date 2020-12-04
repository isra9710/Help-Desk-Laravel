@extends('layouts.mainGuest')
@section('title', 'Añadir archivo')

@section('icon_title')
<i class="far fa-file"></i>
@endsection
@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">   
    <div class="row">
        <div class="col-sm-4">
                <h4 class="text-center alert alert-info ">Añade un archivo</h4>
                
                <form action="{{route('guest.file.store',['ticket'=>$ticket])}}" method="POST" enctype="multipart/form-data">
               

                {{ csrf_field() }}
                <div class="form-group">
                    Escoge un archivo
                 <input type="file" class="form-control-file" name="file">
                </div>
                    <br><br>
                    Añade una descripción
                    <input type="text" class="form-control" required name="fileDescription"><br>
                <input type="submit" class="btn btn-success" value="Agregar">
        
                <a href="{{route('guest.ticket.index',['ticket'=>$ticket])}}" class="btn btn-info">Regresar</a>
                <br>
                <br>
            </form>
        </div>

<div class="col-sm-7 offset-1">
                <h4 class="text-center aler alert-info">Archivos asociados</h4>
                @if(count($files)>0)
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th scope="col">Descripción del archivo</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($files as $file)
                        <tr>
                            <td>{{$file->idFile}}</td>
                            <td>{{$file->fileDescription}}</td>
                            <td> <a href="{{route('administrator.file.download',['file'=>$file])}}">Descargar</a></td>
                             
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            {{$files->render()}}
            @else
            <h4 class="text-center aler alert-warning"> No hay archivos registrados </h4>
            @endif
        </div>          
@endsection
