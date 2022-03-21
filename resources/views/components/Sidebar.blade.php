@section('components.Sidebar')
    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            <li class="nav-item nav-profile">
                <div class="nav-link">
                    <div class="user-wrapper">
                        <div class="profile-image">
                            <img src="{{ asset('images/faces/avatar.jpg') }}" alt="profile image" />
                        </div>
                        <div class="text-wrapper">
                            <p class="profile-name">{{ ucfirst(Auth::user()->name) }} {{ ucfirst(Auth::user()->last_name) }}</p>
                            <div>
                                <small class="designation text-muted">Administrador</small>
                                <span class="status-indicator online"></span>
                            </div>
                        </div>
                    </div>
                    <a href="{{URL::to('logout-panel')}}" class="btn btn-danger btn-block">Cerrar sesión <i class="mdi mdi-exit-to-app"></i></a>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{URL::to('panel')}}">
                    <i class="menu-icon mdi mdi-television"></i>
                    <span class="menu-title">Panel</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{URL::to('clientes')}}">
                    <i class="menu-icon mdi mdi-emoticon-excited"></i>
                    <span class="menu-title">Clientes</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{URL::to('servicios')}}">
                    <i class="menu-icon mdi mdi-basket"></i>
                    <span class="menu-title">Servicios</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{URL::to('reportes')}}">
                    <i class="menu-icon mdi mdi-chart-bar"></i>
                    <span class="menu-title">Reportes</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{URL::to('/panel/servicios-catalogo')}}">
                    <i class="menu-icon mdi mdi-collage"></i>
                    <span class="menu-title">Catálogo de servicios</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{URL::to('configuracion')}}">
                    <i class="menu-icon mdi mdi-settings"></i>
                    <span class="menu-title">Configuración</span>
                </a>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#module0" aria-expanded="false" aria-controls="module0">
                    <i class="menu-icon mdi mdi-image"></i>
                    <span class="menu-title">Sliders</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="module0">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{URL::to('panel/sliders') }}">Lista</a>
                            <a class="nav-link" href="{{URL::to('panel/sliders/slider-crear') }}">Nuevo slider</a>
                        </li>
                    </ul>
                </div>
            </li> --}}
        </ul>
    </nav>
    <!-- partial -->
@endsection