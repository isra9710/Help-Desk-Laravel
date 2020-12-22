
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <img src="{{ asset ('img/hnm.png') }}"
           alt="HNM LOGO"
           class="brand-image img-circle elevation-5"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{env('APP_NAME')}}</span>
    </a>





    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">

        <div class="info">
          <a href="#" class="d-block">Hola {{auth()->user()->name}}</a>
          @if(auth()->user()->idRole <= 4 )
            <a href="#" class="d-block">{{auth()->user()->role->roleName}}</a>
            @if(!(empty(auth()->user()->department->departmentName)))
               <a href="#" class="d-block">{{auth()->user()->department->departmentName}}</a>
            @endif
          @endif
        </div>
      </div>








      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Todo el código a continuación es lo que aparece del lado izquierdo del navegador
              dependiendo del tipo de usuario que inició sesión, son los segmentos que se mostrarán
          -->
        @if(auth()->user()->isAdministrator())
          <li class="nav-header">Estadisticas y reportes</li>
              
                @if(!empty($departmentsSideBar))
                <li class="nav-item has-treeview">
                    <a href="" class="nav-link">
                    <i class="fas fa-chart-pie"></i>
                        <p>
                         Reporte de empleado
                        <i class="right fas fa-angle-left"></i>
                        </p>
                   </a>
                        @foreach ($departmentsSideBar as $department)
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href="{{route('administrator.chart.index.technician',['department'=>$department])}}" class="nav-link">
                                <i class="fas fa-monument"></i>
                              <p>{{$department->departmentName}}</p>
                              </a>
                            </li>
                          </ul>
                         @endforeach
                 </li>
                 @endif
                 @if(!empty($departmentsSideBar))
                <li class="nav-item has-treeview">
                    <a href="" class="nav-link">
                    <i class="fas fa-chart-bar"></i>
                        <p>
                         Reporte de subárea
                        <i class="right fas fa-angle-left"></i>
                        </p>
                   </a>
                        @foreach ($departmentsSideBar as $department)
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href="{{route('administrator.chart.index.subarea',['department'=>$department])}}" class="nav-link">
                                <i class="fas fa-monument"></i>
                              <p>{{$department->departmentName}}</p>
                              </a>
                            </li>
                          </ul>
                         @endforeach
                 </li>
                 @endif
                 @if(!empty($departmentsSideBar))
                <li class="nav-item has-treeview">
                    <a href="" class="nav-link">
                    <i class="fas fa-chart-line"></i>
                      <p>Reporte departamento</p>
                        <i class="right fas fa-angle-left"></i>
                        </p>
                   </a>
                        @foreach ($departmentsSideBar as $department)
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href="{{route('administrator.chart.department',['department'=>$department])}}" class="nav-link">
                                <i class="fas fa-monument"></i>
                              <p>{{$department->departmentName}}</p>
                              </a>
                            </li>
                          </ul>
                         @endforeach
                 </li>
                 @endif


              <li class="nav-item">
              <li class="nav-header">Gestión de preguntas</li>
            <a href="{{route('administrator.question.create')}}" class="nav-link"> 
            <i class="fas fa-question"></i>
              <p>
                Preguntas
              </p>
            </a>
          </li>

          <li class="nav-item">
              <li class="nav-header">Respaldo de la base de datos</li>
            <a href="{{route('administrator.create.backup')}}" class="nav-link"> 
            <i class="fas fa-database"></i>
              <p>
                Respaldar base de datos
              </p>
            </a>
          </li>
          @endif

          
        @if(auth()->user()->isCoordinator())
        <li class="nav-header">Estadisticas y reportes</li>
              
             
        <li class="nav-item">
                <a href="{{route('coordinator.chart.index.technician',['department'=>auth()->user()->department])}}" class="nav-link">
                    <i class="fas fa-chart-pie"></i>
                        <p>
                         Reporte de empleado
                        <i class="right fas fa-angle-left"></i>
                        </p>
                   </a>
                      
                 </li>
              
               
                 <li class="nav-item">
                <a href="{{route('coordinator.chart.index.subarea',['department'=>auth()->user()->department])}}" class="nav-link">
                    <i class="fas fa-chart-bar"></i>
                        <p>
                         Reporte de subárea
                        <i class="right fas fa-angle-left"></i>
                        </p>
                   </a>

                       
                         
                 </li>
                  <li class="nav-item">
                 <a href="{{route('coordinator.chart.department',['department'=>auth()->user()->department])}}" class="nav-link">
                    <i class="fas fa-chart-line"></i>
                      <p>Reporte departamento</p>
                        <i class="right fas fa-angle-left"></i>
                        </p>
                   </a>
                 </li>
                 
          @endif
      






          <li class="nav-header">Gestión de tickets</li>
             <!--
          Para los siguientes enlaces se necesita ser administrador, coordinador o asistente
          en éstos se muestran los tickets abiertos,
          reabiertos,
          cerrados(con menos de 1 mes de antigüedad),
          vencidos(con menos de 1 mes de antigüedad), cancelados.
          -->
            @if(auth()->user()->isAdministrator())
              @if(!empty($departmentsSideBar))
                <li class="nav-item has-treeview">
                    <a href="{{route('administrator.ticket.inbox')}}" class="nav-link">
                    <i  class="fas fa-inbox"></i>
                        <p>
                        Bandeja de entrada
                        <i class="right fas fa-angle-left"></i>
                        </p>
                   </a>
                        @foreach ($departmentsSideBar as $department)
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href="{{route('administrator.ticket.inbox',['department'=>$department])}}" class="nav-link">
                                <i class="fas fa-monument"></i>
                              <p>{{$department->departmentName}}</p>
                              </a>
                            </li>
                          </ul>
                         @endforeach
                 </li>
               @endif
             @elseif(auth()->user()->isCoordinator())
                <li class="nav-item">
                    <a href="{{route('coordinator.ticket.inbox',['department'=>auth()->user()->department])}}" class="nav-link">
                    <i class="fas fa-inbox"></i>
                    <p>
                      Bandeja de entrada
                    </p>
                    </a>
                </li>  
             @else
              @if(auth()->user()->isAssistant())
                    <li class="nav-item">
                    <a href="{{route('assistant.ticket.inbox',['department'=>auth()->user()->department])}}" class="nav-link">
                          <i class="fas fa-inbox"></i>
                          <p>
                            Bandeja de entrada
                          </p>
                          </a>
                      </li>  
              @endif
            @endif
            






          <!--
          Para los siguientes enlaces se necesita ser administrador, coordinador o asistente
          en éstos se muestran los tickets cerrados(con más de 1 mes de antigüedad),
          Vencidos(con más de 1 mes de antigüedad), cancelados.
          -->

          
          
            @if(auth()->user()->isAdministrator())
              @if(!empty($departmentsSideBar))
                <li class="nav-item has-treeview">
                    <a href="{{route('administrator.ticket.historical')}}" class="nav-link">
                    <i class="fas fa-history"></i>
                        <p>
                          Bandeja de histórico
                        <i class="right fas fa-angle-left"></i>
                        </p>
                   </a>
                        @foreach ($departmentsSideBar as $department)
                          <ul class="nav nav-treeview">
                            <li class="nav-item">
                              <a href="{{route('administrator.ticket.historical',['department'=>$department])}}" class="nav-link">
                                <i class="fas fa-monument"></i>
                              <p>{{$department->departmentName}}</p>
                              </a>
                            </li>
                          </ul>
                         @endforeach
                 </li>
                 @endif
             @elseif(auth()->user()->isCoordinator())
                <li class="nav-item">
                    <a href="{{route('coordinator.ticket.historical',['department'=>auth()->user()->department])}}" class="nav-link">
                    <i class="fas fa-history"></i>
                    <p>
                      Bandeja de histórico
                    </p>
                    </a>
                </li>  
             @else
             @if(auth()->user()->isAssistant())
                    <li class="nav-item">
                    <a href="{{route('assistant.ticket.historical',['department'=>auth()->user()->department])}}" class="nav-link">
                       <i class="fas fa-history"></i>
                          <p>
                            Bandeja de histórico
                          </p>
                          </a>
                      </li>  
                @endif
              @endif
          


          



          <li class="nav-item">
          @if(auth()->user()->isAdministrator())
            <a href="{{route('administrator.ticket.create')}}" class="nav-link">
            @elseif(auth()->user()->isCoordinator())
            <a href="{{route('coordinator.ticket.create')}}" class="nav-link">
          @elseif(auth()->user()->isAssistant())
          <a href="{{route('assistant.ticket.create')}}" class="nav-link">
          @elseif(auth()->user()->isAgent()))
          <a href="{{route('agent.ticket.create')}}" class="nav-link">  
          @else
          <a href="{{route('user.ticket.create')}}" class="nav-link">
          @endif  
            <i class="fas fa-paper-plane"></i>
              <p>
                Registrar ticket
              </p>
            </a>
          </li>


        
          @if(!(auth()->user()->isUser()))    
              <li class="nav-item">
              @if(auth()->user()->isAdministrator())
                <a href="{{route('administrator.ticket.create',['guest'=>True])}}" class="nav-link">
                @elseif(auth()->user()->isCoordinator())
                <a href="{{route('coordinator.ticket.create',['guest'=>True])}}" class="nav-link">
              @elseif(auth()->user()->isAssistant())
              <a href="{{route('assistant.ticket.create',['guest'=>True])}}" class="nav-link">
              @else
              @if(auth()->user()->isAgent()))
              <a href="{{route('agent.ticket.create',['guest'=>True])}}" class="nav-link">  
              @endif
              @endif  
                  <i class="fas fa-phone-alt"></i>
                  <p>
                    Ticket para alguien más
                  </p>
                </a>
              </li>
        @endif
          @if(auth()->user()->isAgent())
          <li class="nav-item">
            <a href="{{route('agent.ticket.attend',['user'=>auth()->user()])}}" class="nav-link">
            <i class="fas fa-mail-bulk"></i>
              <p>
                Tickets por atender
              </p>
            </a>
          </li>
        
          @endif


          <li class="nav-item">
          @if(auth()->user()->isAdministrator())
            <a href="{{route('administrator.ticket.mytickets',['employeeNumber'=>auth()->user()->username])}}" class="nav-link">
            @elseif(auth()->user()->isCoordinator())
            <a href="{{route('coordinator.ticket.mytickets',['employeeNumber'=>auth()->user()->username])}}" class="nav-link">
          @elseif(auth()->user()->isAssistant())
          <a href="{{route('assistant.ticket.mytickets',['employeeNumber'=>auth()->user()->username])}}" class="nav-link">
          @elseif(auth()->user()->isAgent()))
          <a href="{{route('agent.ticket.mytickets',['employeeNumber'=>auth()->user()->username])}}" class="nav-link">  
          @else
          <a href="{{route('user.ticket.mytickets',['employeeNumber'=>auth()->user()->username])}}" class="nav-link">
          @endif 
              <i class="fas fa-ticket-alt"></i>
              <p>
                Mis Tickets
              </p>
            </a>
          </li>



          <!--El siguiente código muestra a los asistentes o coordinadores
              la posibilidad de ver los tickets no asignados
          -->
          @if(auth()->user()->isCoordinator() || auth()->user()->isAssistant())
            <li class="nav-item">
            @if(auth()->user()->isCoordinator())
              <a href="{{route('coordinator.ticket.notAssigned',['department'=>auth()->user()->department])}}" class="nav-link">
            @else    
              <a href="{{route('assistant.ticket.notAssigned',['department'=>auth()->user()->department])}}" class="nav-link">
            @endif
            <i class="fas fa-bell"></i>
              <p>
                Tickets no asignados
              </p>
              </a>
              </li>
          @endif





          @if(auth()->user()->isAdministrator())
          @if(!empty($departmentsSideBar))
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="far fa-bell"></i>
              <p>
                Tickets no asignados
              <i class="right fas fa-angle-left"></i>
              </p>
             </a>
             @foreach ($departmentsSideBar as $department)
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{route('administrator.ticket.notAssigned',['department'=>$department])}}" class="nav-link">
                      <i class="fas fa-monument"></i>
                    <p>{{$department->departmentName}}</p>
                    </a>
                  </li>
                </ul>
              @endforeach
          </li>
          @endif
          @endif














          <!--
          La siguiente sección es para que un usuario administrador pueda
          hacer gestión de los departamentos,subáreas y actividades
           por lo tanto
          sólo quien inicie sesión y cumpla con el rol de
          administrador podrá ver lo siguiente
          -->


          @if(auth()->user()->isAdministrator())
            @if(!empty($departmentsSideBar))
            <li class="nav-header">Gestión de departamentos</li>
            <li class="nav-item">
              <!--Aquí no necesitamos hacer ningún filtro
                pues se necesitan listar todos los departamentos

              -->
              <a href="{{route('administrator.department.index')}}" class="nav-link">
                <i class="fas fa-hotel"></i>
                <p>
                  Departamentos
                  
                </p>
              </a>
            </li>




            <li class="nav-header">Gestión de subareas</li>
            <!--
            En la siguiente parte se necesita iterar
            por departamentos, para hacer gestión de sus propias subáreas
            -->
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="fas fa-gopuram"></i>
                  <p>
                    Departamentos
                  <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                @foreach ($departmentsSideBar as $department)
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="{{route('administrator.subarea.index',['department'=>$department])}}" class="nav-link">
                          <i class="fas fa-monument"></i>
                        <p>{{$department->departmentName}}</p>
                        </a>
                      </li>
                    </ul>
                @endforeach
            </li>



            <li class="nav-header">Gestión de actividades</li>
            @if(!(empty($subareasSideBar)))
            <!--
              Iteramos sobre departamentos y luego sobre subáreas,
              para hacer gestión de las actividades de cada subárea
            -->
              @foreach ($departmentsSideBar as $department)
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="fas fa-building"></i>
                    <p>
                      {{$department->departmentName }}
                    <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  @foreach ($subareasSideBar as $subarea)
                    @if($subarea->idDepartment==$department->idDepartment)
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="{{route('administrator.activity.index',['subarea'=>$subarea])}}" class="nav-link">
                            <i class="far fa-building"></i>
                          <p>{{$subarea->subareaName}}</p>
                          </a>
                        </li>
                      </ul>
                    @endif
                  @endforeach
              </li>
                  @endforeach
              @endif
            @endif
          @endif








          @if(auth()->user()->isCoordinator())
           <li class="nav-header">Gestión de subareas</li>
           <li class="nav-item">
            <a href="{{route('coordinator.subarea.index',['department'=>auth()->user()->department])}}" class="nav-link">
              <i class="fas fa-hotel"></i>
              <p>
                Subáreas
                <span class="badge badge-info right">100</span>
              </p>
            </a>
          </li>
           <li class="nav-header">Gestión de actividades</li>
           <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-gopuram"></i>
              <p>
                Subareas
              <i class="right fas fa-angle-left"></i>
              </p>
             </a>
             @foreach ($subareasSideBar as $subarea)
              @if(auth()->user()->idDepartment==$subarea->idDepartment)
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{route('coordinator.activity.index',['subarea'=>$subarea])}}" class="nav-link">
                      <i class="fas fa-monument"></i>
                    <p>{{$subarea->subareaName}}</p>
                    </a>
                  </li>
                </ul>
                @endif
              @endforeach
          </li>
          @endif










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
                    @if(!empty($departmentsSideBar))
                      @foreach ($departmentsSideBar as $department)
                            <li class="nav-item has-treeview">
                              <a href="#" class="nav-link">
                                <i class="fas fa-building"></i>
                                <p>
                                  {{$department->departmentName }}
                                <i class="right fas fa-angle-left"></i>
                                </p>
                              </a>
                                @foreach ($rolesSideBar as $role)
                                  @if(($role->idRole!=1 ) && ($role->idRole != 5)&& ($role->idRole!=6))
                                  <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                      <a href="{{route('administrator.user.index',['idRole'=>$role->idRole, 'idDepartment'=>$department->idDepartment])}}" class="nav-link">
                                        <i class="far fa-building"></i>
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
                      @if(!empty($rolesSideBar))
                          @foreach ($rolesSideBar as $role)
                              @if($role->idRole!=1 && $role->idRole!=2 && $role->idRole!=5 && $role->idRole!=6 )
                                <li class="nav-item">
                                  <a href="{{route('coordinator.user.index',['idRole'=>$role->idRole, 'idDepartment'=> Auth()->user()->idDepartment])}}" class="nav-link">
                                    <i class="fas fa-user-cog"></i>
                                  <p>{{$role->roleName}}</p>
                                  </a>
                                </li>
                              @endif
                        @endforeach
                      @endif
                  @endif



                  <!--Por último, si el usuario que se logueo es un asistente, sólo podrá hacer gestión de
                    los técnicos correspondientes a su departamento
                    -->
                    @if(auth()->user()->isAssistant())
                      @foreach ($rolesSideBar as $role)
                        @if($role->idRole==4)
                          <li class="nav-item">
                            <a href="{{route('assistant.user.index',['idRole'=>$role->idRole, 'idDepartment'=> Auth()->user()->idDepartment])}}" class="nav-link">
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
                    @if(!empty($rolesSideBar))
                        @foreach ($rolesSideBar as $role)
                          @if($role->idRole==5)

                            <li class="nav-item">
                              @if(auth()->user()->isAdministrator())

                              <a href="{{route('administrator.user.index',['idRole'=>$role->idRole, 'idDepartment'=> 'null'])}}" class="nav-link">
                              @else
                              <a href="{{route('coordinator.user.index',['idRole'=>$role->idRole, 'idDepartment'=> 'null'])}}" class="nav-link">
                                @endif
                                <i class="fas fa-user-cog"></i>
                              <p>{{$role->roleName}}</p>
                              </a>
                            </li>
                          @endif
                        @endforeach
                    @endif
                  @endif


        @endif



      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
