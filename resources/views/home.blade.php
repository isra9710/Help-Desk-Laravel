@extends('layouts.main')

@section('title', 'Inicio')  


@section('icon_title')
    <i class="fa fa-home"></i>
@endsection
  
@section('content')
<div class="card">
        <div class="card-header">
          <h3 class="card-title">Página principal</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
         A tu lado izquierdo encontrarás todas las actividades disponibles para un {{auth()->user()->role->roleName}}
         <br>
         Escoge para poder empezar a trabajar
        </div>
       
       
 </div>

@endsection