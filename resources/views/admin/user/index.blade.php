@extends('layouts.app')

@section('title', 'Listado de usuarios')

@section('icon_title')
<i class="fa fa-fw fa-user"></i>
@endsection

@section('content')
<div class="card">
        <div class="card-header">
          <h3 class="card-title">Listado de empleados</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i>
            </button>
              <a href="" title="Crear Usuario"/>
              <i class="fa fa-plus"></i>
          </a>

          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
          <table class="table table-hover">
          <thead>
            <tr>
              <th>Nombre
              <th>Apellidos</th>
              <th>Correo</th>
              <th>Nombre de usuario</th>
              <th>Tipo de Usuario</th>
            </tr>
           </thead>
          <tbody>
          @foreach($users as $user)
          <tr>
            <td>{{ $user->firstname}}</td>
            <td><a href="/usuarios/"></a></td>
            <td>{{$user->lastname }}</td>
            <td>{{$user->email }}</td>
            <td>{{$user->username}}</td>
            <td>{{$user->idTypeU}}</td>
          </tr>
          @endforeach
          </tbody>
          </table>

          </div>
            {{ $users->render() }}
        </div>

</div>

@endsection
