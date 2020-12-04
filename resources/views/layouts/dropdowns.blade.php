<ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        
        
      <!--uSER-->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-power-off"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
         
          <div class="dropdown-divider"></div>
          @if(auth()->user()->isAdministrator())
             <a href="{{route('administrator.change.pass')}}" class="dropdown-item">
          @elseif(auth()->user()->isCoordinator())
            <a href="{{route('coordinator.change.pass')}}" class="dropdown-item">
          @elseif(auth()->user()->isAssistant())
             <a href="{{route('assistant.change.pass')}}" class="dropdown-item">
          @elseif(auth()->user()->isAgent())
            <a href="{{route('agent.change.pass')}}" class="dropdown-item">
        @else
          <a href="{{route('user.change.pass')}}" class="dropdown-item">
        @endif
        <i class="fas fa-lock text-warning"></i> Cambiar contraseña
          </a>
          
          
          
          <a href="javascript:{}" onclick="document.getElementById('formLogout').submit(); return false;" class="dropdown-item">
            <i class="fa fa-lg fa-sign-out-alt text-danger"></i> Cerrar Sesión
          </a>
          <form action="{{route('logout')}}" method="POST"  id="formLogout">@csrf</form>
        
         
        </div>

       
      </li>
     
    </ul>