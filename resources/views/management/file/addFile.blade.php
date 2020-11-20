@extends('layouts.main')
@section('title', 'Añadir archivo')

@section('icon_title')
<i class="far fa-file"></i>
@endsection
@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

   
    <div class="row">
        <div class="col-sm-4">
                <h4 class="text-center alert alert-info ">Añade un archivo</h4>
                @if(Auth::user()->isAdministrator())
                <form action="{{route('administrator.file.store',['ticket'=>$ticket])}}" method="POST" enctype="multipart/form-data">
                @else
                <form action="{{route('coordinator.file.store',['ticket'=>$ticket,'my'=>FALSE])}}" method="POST" enctype="multipart/form-data">
                @endif
                {{ csrf_field() }}
                <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="file" name="file">
                        <label class="custom-file-label" for="file">Busca un archivo</label>
                      </div>
                      
                    </div>
                    <br><br>
                <input type="submit" class="btn btn-success" value="Agregar">
                @if(auth()->user()->isAdministrator())
                <a href="{{route('administrator.ticket.inbox',$ticket->activity->subarea->department)}}" class="btn btn-info">Regresar</a>
                @else
                <a href="{{route('coordinator.ticket.inbox',$ticket->activity->subarea->department)}}" class="btn btn-info">Regresar</a>
                @endif
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
                        <th scope="col">Nombre del archivo </th>
                        <th scope="col">Descargar</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($files as $file)
                        <tr>
                            <td>{{$file->idFile}}</td>
                            <td>{{$file->directoryFile}}</td>
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
