@extends('layouts.main')

@section('title', 'Gestión de preguntas')

@section('icon_title')
<i class="fas fa-question"></i>

@endsection


@section('content')
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

   
    <div class="row">
        <div class="col-sm-4">
                <h4 class="text-center alert alert-info ">Agregar nueva pregunta(escribe la pregunta sin "¿?")</h4>
                @if(auth()->user()->isAdministrator())
                <form action="{{route('administrator.question.store')}}" method="POST">
                @else
                <form action="{{route('coordinator.question.store')}}" method="POST">
                @endif 
                {{ csrf_field() }}

                    Pregunta
                    <input type="text" class="form-control" required name="question">

                <br><br>
                <input type="submit" class="btn btn-success" value="Agregar">
                <br>
                <br>
            </form>
        </div>

        <div class="col-sm-7 offset-1">
                <h4 class="text-center aler alert-info">Preguntas Registradas</h4>
                @if(count($questions)>0)
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th scope="col">Pregunta </th>
                        <th scope="col">Acciones</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($questions as $question)
                        <tr>
                            <td>{{$question->idQuestion}}</td>
                            <td>{{ $question->question}}</td>
                            <td>
                                @if(auth()->user()->isAdministrator())
                                    <a href="{{route('administrator.question.edit', ['question'=>$question])}}" class="btn
                                    btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                @else
                                    @if($question->active)
                                        <a href="{{route('coordinator.question.edit', ['question'=>$question])}}" class="btn
                                            btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    @endif
                                @endif
                            @if(auth()->user()->isAdministrator())
                                <form action="{{route('administrator.question.destroy', ['question'=>$question])}}"
                                      method="POST" class="d-inline">
                                    {{ csrf_field() }}
                                    @if($question->active)
                                    <input type="submit" onclick="return confirm('¿Seguro que desa desactivar?');" class="btn btn-danger btn-sm" value="X">
                                    @else
                                    <input type="submit" onclick="return confirm('¿Seguro que desea activar?');"  class="btn btn-success"   value="✓">
                                    @endif
                                </form>
                            @else
                                @if($question->active)
                                    <form action="{{route('coordinator.question.destroy', ['question'=>$question])}}"
                                            method="POST" class="d-inline">
                                            <input type="submit" onclick="return confirm('¿Seguro que desea desactivar?');"  class="btn btn-danger btn-sm"   value="X">
                                            
                                        </form>
                                @endif
                            @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            {{$questions->render()}}
            @else
            <h4 class="text-center aler alert-warning"> No hay registro de preguntas</h4>
            @endif
        </div>

@endsection