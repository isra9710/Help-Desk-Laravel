
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        @if(auth()->user()->isAdministrator())
        <a href="{{route('administrator.home')}}" class="nav-link">Página principal</a>
        @elseif(auth()->user()->isCoordinator())
          <a href="{{route('coordinator.home')}}" class="nav-link">Página principal</a>
        @elseif(auth()->user()->isAssistant())
        <a href="{{route('assistant.home')}}" class="nav-link">Página principal</a>
        @elseif(auth()->user()->isAgent())
        <a href="{{route('agent.home')}}" class="nav-link">Página principal</a>
        @else
        <a href="{{route('user.home')}}" class="nav-link">Home</a>
        @endif
      </li>
     
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="hidden" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="hidden">
            
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
 @include('layouts.dropdowns')
</nav>
