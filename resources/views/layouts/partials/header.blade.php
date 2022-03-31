<header id="header">
    <div class="center">
        <div id="logo">
            <a href="">
                <img src="{{asset('images/logo_ruso.png')}}" class="app-logo" alt="logotipo" />
            </a>
        </div>
        <nav id="menu">
            <ul>
                {{-- <li><a href="{{route('socios.index')}}" class="{{request()->routeIs('socios.*') ? 'active' : ''}}" >Distribuidores</a></li>
                <li><a href="{{route('reportes.index')}}" class="{{request()->routeIs('reportes.*') ? 'active' : ''}}" >Reportes</a></li>
                <li><a href="{{route('administracion.index')}}" class="{{request()->routeIs('administracion.*') ? 'active' : ''}}" >Administración</a></li>
                <li><a href="{{route('ayuda.index')}}" class="{{request()->routeIs('ayuda.*') ? 'active' : ''}}" >Ayuda</a></li> --}}
                {{-- <li><a href="{{route('logout.perform')}}">Salir</a></li> --}}
            </ul>
        </nav>
        <!--Limpiar los FLOATS-->
        <div class="clear-fix"></div>
    </div>
</header>
