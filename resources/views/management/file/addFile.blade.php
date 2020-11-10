@extends('layouts.main')
@section('title', 'Añadir archivo')

@section('icon_title')
<i class="fas fa-ticket-alt"></i>
@endsection
@section('content')
<div class="col-sm-12 offset-0" id="ticket">
  <h4 class="text-center alert alert-info ">Añade un archivo</h4>
  @if(Auth::user()->isAdministrator())
      <form action="{{route('administrator.file.store')}}" method="POST" enctype="multipart/form-data">
  @elseif(Auth::user()->isCoordinator())
      <form action="{{route('coordinator.file.store')}}" method="POST" enctype="multipart/form-data">
  @elseif(Auth::user()->isAssistant())
     <form action="{{route('assistant.file.store')}}" method="POST" enctype="multipart/form-data">
  @elseif(Auth::user()->isAgent())
     <form action="{{route('agent.file.store')}}" method="POST" enctype="multipart/form-data">
  @else
      <form action="{{route('user.file.store')}}" method="POST" enctype="multipart/form-data">
  @endif
  {{ csrf_field() }}


  <br><br>

  

<br><br>

  Asociar archivo al ticket
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="file" name="file">
                        <label class="custom-file-label" for="file">Busca un archivo</label>
                      </div>
                      
                    </div>


</div>
  <br><br>
  <input type="submit" class="btn btn-success" value="Agregar">
  <br><br>
</form>
</div>
               
                  
@endsection
