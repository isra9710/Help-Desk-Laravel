@extends('layouts.main')
@section('title', 'Añadir comentario')

@section('icon_title')
<i class="fas fa-comment-alt"></i>
@endsection
@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

 
<div class="row">
<div class="col-sm-4">
<h4 class="text-center alert alert-info ">Añade un comentario</h4>
@if(Auth::user()->isAdministrator())
<form action="{{route('administrator.message.store',['ticket'=>$ticket,'option'=>$option])}}" method="POST">
@elseif(Auth::user()->isCoordinator())
<form action="{{route('coordinator.message.store',['ticket'=>$ticket,'option'=>$option])}}" method="POST">
@elseif(Auth::user()->isAssistant())
<form action="{{route('assistant.message.store',['ticket'=>$ticket,'option'=>$option])}}" method="POST">
@elseif(Auth::user()->isAgent())
<form action="{{route('agent.message.store',['ticket'=>$ticket,'option'=>$option])}}" method="POST">
@else
<form action="{{route('user.message.store',['ticket'=>$ticket,'option'=>$option])}}" method="POST">
@endif
  
                {{ csrf_field() }}

 
                <textarea class="form-control" required name="text" rows="3"></textarea>
                    <br><br>
                <input type="submit" class="btn btn-success" value="Agregar">
                <a href="{{ URL::previous() }}" class="btn btn-info">Regresar</a>
                <br>
                <br>
            </form>
        </div>

<div class="col-sm-7 offset-1">
                <h4 class="text-center aler alert-info">Mensajes asociados</h4>
                @if(count($messages)>0)
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th scope="col">Mensaje </th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($messages as $message)
                        <tr>
                            <td>{{$message->idMessage}}</td>
                            <td>{{$message->text}}</td>                         
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            {{$messages->render()}}
            @else
            <h4 class="text-center aler alert-warning"> No hay mensajes de este ticket </h4>
            @endif
        </div>          
@endsection
