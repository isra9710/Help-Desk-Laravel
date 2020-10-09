@extends('layouts.main')
@section('title', 'Ticket')

@section('icon_title')
<i class="fas fa-ticket-alt"></i>

@endsection

@section('content')
<div class="col-sm-12 offset-0">
  <h4 class="text-center alert alert-info ">Agregar nueva subárea para {{--$department->departmentName--}}</h4>
  <form action="{{--route('administrator.subarea.create',['department'=>$department])--}}" method="POST">
  {{ csrf_field() }}

      Nombre
      <input type="text" class="form-control" required name="subareaName">

  <br><br>

      Descripción
      <input type="text" class="form-control" required name="lastname">
  <br><br>
  <input type="submit" class="btn btn-success" value="Agregar">
  <br>
  <br>
</form>
</div>
 
                  <!-- /.input group -->
           
                <!-- /.form group -->
                  <!--<div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                  </div>-->
                  
@endsection
