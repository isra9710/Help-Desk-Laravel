@extends('layouts.main')

@section('title', 'Pregunta')

@section('icon_title')
<i class="fas fa-question"></i>
@endsection


@section('content')
        <div class="row">
            <div class="col-sm-8 offset-2">
            <h4 class="text-center alert alert-info ">Editar pregunta</h4>
            @if(auth()->user()->isAdministrator())
            <form action="{{route('administrator.question.update', ['question'=>$question])}}" method="POST">
            @else
            <form action="{{route('cordinator.question.update', ['question'=>$question])}}" method="POST">
            @endif
                
                    {{ csrf_field() }}

                        Pregunta
                        <input type="text" class="form-control" required name="question" value="{{$question->question}}">

                    <br><br>

                      

                    <input type="submit" class="btn btn-success" value="Actualizar">
                    
                    <a href="{{ URL::previous() }}" class="btn btn-info">Regresar</a>
                    <br>
                    <br>
                </form>
            </div>

@endsection
