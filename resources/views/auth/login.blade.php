<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>@yield('title', 'Inicio')|{{env('APP_NAME')}} </title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
      
        <!-- Font Awesome -->
       <!-- <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">-->
       <link rel="stylesheet" href="{{ mix('css/app.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- overlayScrollbars -->
       <!-- <link rel="stylesheet" href="../../dist/css/adminlte.min.css">-->
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
      </head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
  <a href="/"><b>{{env('APP_NAME')}}</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Inicia sesión</p>
    <form action="{{ route('login')}}" method="POST">
      @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Número de empleado" @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required  autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          @error('username')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Contraseña" @error('password') is-invalid @enderror" name="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          @error('password')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
        </div>
        <div class="row">
          
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
          </div>
          <!-- /.col -->
        </div>

       
        @if (Route::has('register'))
        <p class="mb-0">
          <a href="{{ route('register') }}" class="text-center">Registrarse</a>
        </p>
        @endif
        <p class="mb-0">
          <a href="{{ route('guest.ticket.create') }}" class="text-center">Registrar ticket</a>
        </p>
        <p class="mb-0">
          <a href="" data-toggle="modal" data-target="#modal-default" class="text-center" > Buscar ticket</a>
        </p>

        </div>
    </div>
      </form>




      <div class="modal fade" id="modal-default">
         <form action="{{route('guest.ticket.index')}}" method="GET">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Buscar ticket</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            
            Número de ticket
          <input class="form-control" required name="idTicket" >
              
              
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            
              <button type="submit" class="btn btn-success">Buscar ticket</button>            
            </div>
            </form>
          </div>
       
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>




      
      <script src="{{ mix('js/vendor.js') }}"></script>
    <script src=" {{ mix('js/app.js') }}?v3" defer></script> 
    @if(session()->has('process_result'))
        <script>
        $(function(){
           toastr.{{session('process_result')['status']}}('{{session
            ('process_result')['content']}}')
        });
        </script>
        @endif
<!-- /.login-box -->

</body>
</html>
