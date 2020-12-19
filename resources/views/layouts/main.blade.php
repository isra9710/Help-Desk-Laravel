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
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar  se incluye el archivo navbar.blada.php-->
 @include('layouts.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
 @include('layouts.sidebar')
  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>@yield('icon_title') @yield('title', 'Inicio')</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @if($errors->any())
    <h4>{{$errors->first()}}</h4>
    
    @endif
    <!-- Main content -->
    <section class="content">
    @yield('content')
      <!-- Default box -->
  
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!-- footer-->
@include('layouts.footer')
<!-- ./footer-->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<script src="{{ mix('js/vendor.js') }}"></script>
<script src=" {{ mix('js/app.js') }}?v3"></script> 


@yield('scripts')
@if(session()->has('process_result'))
        <script>
        $(function(){
           toastr.{{session('process_result')['status']}}('{{session
            ('process_result')['content']}}')
        });
        </script>    
@endif




</body>
</html>
