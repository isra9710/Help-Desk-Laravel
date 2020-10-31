@extends('layouts.main')
@section('title', 'Ticket')

@section('icon_title')
<i class="fas fa-ticket-alt"></i>

@endsection

@section('content')
@inject('departments','App\Services\Departments')
<div class="col-sm-12 offset-0" id="ticket">
  <h4 class="text-center alert alert-info ">Registra un ticket</h4>
  @if(Auth::user()->isAdministrator())
      <form action="{{route('administrator.ticket.store')}}" method="POST" enctype="multipart/form-data">
  @elseif(Auth::user()->isCoordinator())
      <form action="{{route('coordinator.ticket.store')}}" method="POST" enctype="multipart/form-data">
  @elseif(Auth::user()->isAssistant())
     <form action="{{route('assistant.ticket.store')}}" method="POST" enctype="multipart/form-data">
  @elseif(Auth::user()->isAgent())
     <form action="{{route('agent.ticket.store')}}" method="POST" enctype="multipart/form-data">
  @else
      <form action="{{route('user.ticket.store')}}" method="POST" enctype="multipart/form-data">
  @endif
  {{ csrf_field() }}


  <br><br>

    Departamento
        
            <select v-model="selected_department"  @change="loadSubareas" id="department" data-old="{{ old('idDepartment') }}"name="idDepartment" class="form-control{{ $errors->has('idDepartment') ? ' is-invalid' : '' }}">
                @foreach($departments->getDepartments() as $index => $department)
                    <option value="{{ $index }}">
                        {{ $department }}
                    </option>
                @endforeach
            </select>

            @if ($errors->has('idDepartment'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('idDepartment') }}</strong>
                </span>
            @endif

<br><br>



        Subárea

       
            <select v-model="selected_subarea" id="subarea" @change="loadActivities" data-old="{{ old('idSubarea') }}" name="idSubarea" class="form-control{{ $errors->has('idSubarea') ? ' is-invalid' : '' }}">
                <option value="">Selecciona una subarea</option>
                <option v-for="(subarea, index) in subareas" v-bind:value="index">
                    @{{subarea}}
                </option>>
            </select>

            @if ($errors->has('idSubarea'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('idSubarea') }}</strong>
                </span>
            @endif
     
            <br><br>


            Actividades
            <select v-model="selected_activity" id="activity" data-old="{{ old('idActivity') }}" name="idActivity" class="form-control{{ $errors->has('idActivity') ? ' is-invalid' : '' }}">
                <option value="">Selecciona una actividad</option>
                <option v-for="(activity, index) in activities" v-bind:value="index">
                    @{{activity}}
                </option>>
            </select>

            @if ($errors->has('idActivity'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('idActivity') }}</strong>
                </span>
            @endif

<br><br>

  Asociar archivo al ticket
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="file" name="file">
                        <label class="custom-file-label" for="file">Busca un archivo</label>
                      </div>
                      
                    </div>


<br><br>

  Descripción
      <textarea class="form-control" required name="description" rows="3"></textarea>
  <br><br>
  <div class="form-check">
  <input class="form-check-input" type="checkbox"  id="doubt" name="doubt">
  <label class="form-check-label" for="doubt">
    No estoy seguro de las subáreas
  </label>
</div>
  <br><br>
  <input type="submit" class="btn btn-success" value="Agregar">
  <br><br>
</form>
</div>
               
                  
@endsection
