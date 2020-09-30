
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <img src="{{ asset ('img/AdminLTELogo.png') }}"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{env('APP_NAME')}}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <!--  <img src="{{ asset ('img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">-->
        </div>
        <div class="info">
        <a href="#" class="d-block">Hola {{auth()->user()->name}}</a>
        @if(auth()->user()->idRole <= 4 )
          <a href="#" class="d-block">{{auth()->user()->idRole->nameRole}}</a>
          @endif
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="fas fa-building"></i>
                  <p>
                    Dashboard
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="../../index.html" class="nav-link">
                      <i class="fas fa-user-cog"></i>
                      <p>Dashboard v1</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../../index2.html" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Dashboard v2</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../../index3.html" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Dashboard v3</p>
                    </a>
                  </li>
                </ul>
              </li>
          <li class="nav-item">
            <a href="../calendar.html" class="nav-link">
              <i class="nav-icon fas fa-arrows-alt"></i>
              <p>
                Gestión
                <span class="badge badge-info right">2</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../gallery.html" class="nav-link">
            <i class="fas fa-ticket-alt"></i>
              <p>
                Tickets
              </p>
            </a>
          </li>



          @if(auth()->user()->isAdministrator())
          <li class="nav-header">Gestión de departamentos</li>
          <li class="nav-item">
            <a href="../calendar.html" class="nav-link">
            <i class="fas fa-building"></i>
              <p>
                Tipos
                <span class="badge badge-info right">2</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../gallery.html" class="nav-link">
            <i class="fas fa-thermometer-quarter"></i>
              <p>
                Prioridades
              </p>
            </a>
          </li>
          @endif





          <li class="nav-header">REPORTES</li>
          <li class="nav-item">
            <a href="../calendar.html" class="nav-link">
            <i class="fas fa-folder-plus"></i>
              <p>
                Nuevos Creados
                <span class="badge badge-info right">2</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../gallery.html" class="nav-link">
            <i class="fas fa-tasks"></i>
              <p>
                Pendientes
              </p>
            </a>
          </li>

          <!-- La siguiente sección es para hacer gestión de usuarios, dependiendo del tipo de permisos
              que se tengan, sólo los administradores, coordinadores y asistentes pueden hacer uso de lo siguiente
              dependiedo del nivel de permiso, se le muestran tipos de usuario
          -->
        @if(auth()->user()->isAdministrator() || auth()->user()->isCoordinator() || auth()->user()->isAssistant())
            <li class="nav-header">Gestión de personal</li>
            <!--Si el usuario es un administrador, se le va a mostrar la sección dividida por 
                departamentos y después por roles haciendo excepción con los usuarios y los invitados
                porque éstos se le muestran a dos tipos de usuario, administrador y coordinador
            -->
              @if(auth()->user()->isAdministrator())
                @if(!empty($departments))    
                  @foreach ($departments as $department)
                        <li class="nav-item has-treeview">
                          <a href="#" class="nav-link">
                            <i class="fas fa-building"></i>
                            <p>
                              {{$department->departmentName }}
                            <i class="right fas fa-angle-left"></i>
                            </p>
                           </a>
                            @foreach ($roles as $role)
                              @if(($role->idRole!=1 ) && ($role->idRole != 5)&& ($role->idRole!=6))
                              <ul class="nav nav-treeview">
                                <li class="nav-item">
                                  <a href="{{route('administrator.user.index',['role'=>$role->idRole, 'department'=>$department->idDepartment])}}" class="nav-link">
                                    <i class="fas fa-user-cog"></i>
                                  <p>{{$role->roleName}}</p>
                                  </a>
                                </li>
                              </ul>
                              @endif
                            @endforeach
                        </li>
                  @endforeach
                @endif
              @endif



               <!--Si el usuario es coordinador, solamente se le van a mostrar los roles de su departamento
                  técnico, asistente.
              -->
              @if(auth()->user()->isCoordinator())
                @foreach ($roles as $role)
                @if($role->idRole!=1 && $role->idRole!=2 && $role->idRole!=5 && $role->idRole!=6 )
                  <li class="nav-item">
                    <a href="{{route('administrator.user.index',['role'=>$role->idRole, 'department'=> Auth()->user()->idDepartment])}}" class="nav-link">
                      <i class="fas fa-user-cog"></i>
                    <p>{{$role->roleName}}</p>
                    </a>
                  </li>
                @endif
              @endforeach
              @endif



               <!--Por último, si el usuario que se logueo es un asistente, sólo podrá hacer gestión de 
                los técnicos correspondientes a su departamento
                -->
                @if(auth()->user()->isAssistant())
                  @foreach ($roles as $role)
                    @if($role->idRole!=1 && $role->idRole!=2 &&$role->idRole!=3 && $role->idRole!=5 && $role->idRole!=6 )
                      <li class="nav-item">
                        <a href="{{route('administrator.user.index',['role'=>$role->idRole, 'department'=> Auth()->user()->idDepartment])}}" class="nav-link">
                          <i class="fas fa-user-cog"></i>
                        <p>{{$role->roleName}}</p>
                        </a>
                      </li>
                    @endif
                  @endforeach
                @endif
              
              
              
              
              
              <!--Aquí es donde se muestran los usuarios y los invitados
              -->
              @if(auth()->user()->isAdministrator() || auth()->user()->isCoordinator())
                  @foreach ($roles as $role)
                    @if($role->idRole==5 ||$role->idRole==6 )
                      <li class="nav-item">
                        <a href="{{route('administrator.user.index',['role'=>$role->idRole, 'department'=> 'null'])}}" class="nav-link">
                          <i class="fas fa-user-cog"></i>
                        <p>{{$role->roleName}}</p>
                        </a>
                      </li>
                    @endif
                  @endforeach
              @endif
            
                 
        @endif          

        

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>



 
