@extends('layouts.main')
@section('title', 'Cambia tu contraseña')

@section('icon_title')
<i class="fas fa-key"></i>
@endsection
@section('content')
<div class="col-sm-12 offset-0" id="ticket">
  <h4 class="text-center alert alert-info ">Cambiar contraseña</h4>

  @if(Auth::user()->isAdministrator())
      <form action="{{route('administrator.update.pass')}}" method="POST">
  @elseif(Auth::user()->isAdministrator())
  <form action="{{route('coordinator.update.pass')}}" method="POST">
  @elseif(Auth::user()->isAdministrator())
  <form action="{{route('assistant.update.pass')}}" method="POST">
  @elseif(Auth::user()->isAdministrator())
  <form action="{{route('agent.update.pass')}}" method="POST">
@else
<form action="{{route('user.update.pass')}}" method="POST">
  @endif
  {{ csrf_field() }}
        Contraseña actual
        <input type="password"  required class="form-control" name="currentPass">
        Nueva contraseña
        <input type="password"  required class="form-control" name="newPass">
        Repite la contraseña
        <input type="password"  required class="form-control" name="confPass">
        <br>
        <input type="submit" class="btn btn-success" value="Cambiar">
        <a href="{{ URL::previous() }}" class="btn btn-info">Regresar</a>
        <br>
        <br>
        
</form>
</div>
               
                  
@endsection