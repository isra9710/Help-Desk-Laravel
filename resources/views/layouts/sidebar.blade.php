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
          <a href="#" class="d-block">Aquí va el nombre del usuario</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
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
          <li class="nav-header">CONFIGURACIÓN</li>
          <li class="nav-item">
            <a href="../calendar.html" class="nav-link">
            <i class="fas fa-map-signs"></i>
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
          <li class="nav-header">Administración</li>
          <li class="nav-item">
            <a href="../calendar.html" class="nav-link">
            <i class="fas fa-user-cog"></i>
              <p>
                Usuarios
                <span class="badge badge-info right">2</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../gallery.html" class="nav-link">
            <i class="fas fa-lock"></i>
              <p>
                Roles
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../gallery.html" class="nav-link">
            <i class="fas fa-check"></i>
              <p>
                Permisos
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
