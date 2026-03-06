<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, user-scalable=no" name="viewport">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <title>@yield('titulo', "Inicio")</title>

    {{-- Token CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://tresplazas.com/web/img/big_punto_de_venta.png" rel="shortcut icon">
    
    {{-- CSS Base --}}
    <link href="{{asset('app/publico/css/lib/font-awesome/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('bootstrap5/css/bootstrap.min.css')}}" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <link rel="stylesheet" href="{{asset('app/publico/css/lib/lobipanel/lobipanel.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/publico/css/separate/vendor/lobipanel.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/publico/css/lib/jqueryui/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/publico/css/separate/pages/widgets.min.css')}}">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('fontawesome/css/fontawesome.min.css')}}">

    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="{{asset('app/publico/css/lib/datatables-net/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/publico/css/separate/vendor/datatables-net.min.css')}}">

    <link href="{{asset('app/publico/css/lib/bootstrap/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('app/publico/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('app/publico/css/mis_estilos/estilos.css')}}" rel="stylesheet">

    {{-- Form & Personalizados --}}
    <link rel="stylesheet" type="text/css" href="{{asset('app/publico/css/lib/jquery-flex-label/jquery.flex.label.css')}}">
    <link href="{{asset('principal/css/estilos.css')}}" rel="stylesheet">

    {{-- pNotify CSS --}}
    <link href="{{asset('pnotify/css/pnotify.css')}}" rel="stylesheet" />
    <link href="{{asset('pnotify/css/pnotify.buttons.css')}}" rel="stylesheet" />
    <link href="{{asset('pnotify/css/custom.min.css')}}" rel="stylesheet" />

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        .marca {
            width: 100%;
            background: rgb(13, 39, 48);
            position: fixed;
            bottom: 0;
            z-index: 999;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
        }
        .marca__parrafo { margin: 0 !important; color: white; }
        .marca__texto { color: rgb(0, 162, 255); text-decoration: underline; }
        .marca__parrafo span { color: red; }
    </style>
    @laravelPWA
</head>

<body class="with-side-menu">
    <div id="app">
        <header class="site-header">
            <div class="container-fluid" style="padding-left: 40px;">
                <button id="show-hide-sidebar-toggle" class="show-hide-sidebar menu">
                    <span>toggle menu</span>
                </button>
                <button class="hamburger hamburger--htla">
                    <span>toggle menu</span>
                </button>

                <div class="site-header-content">
                    <div class="site-header-content-in">
                        <div class="site-header-shown">
                            <div class="dropdown dropdown-notification">
                                <h6 class="mt-2 nomTipo">
                                    {{ Auth::user()->tipo_usuario === 1 ? 'Administrador' : 'Usuario' }}
                                </h6>
                            </div>

                            <div class="dropdown user-menu">
                                <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if (Auth::user()->foto == null)
                                        <img src="{{asset('app/publico/img/user.svg')}}" alt="">
                                    @else
                                        <img class="img" src="{{ asset('storage/FOTOS-PERFIL-USUARIO/'.Auth::user()->foto) }}" alt="">
                                    @endif
                                </button>
                                <div class="dropdown-menu dropdown-menu-right pt-0" aria-labelledby="dd-user-menu">
                                    <h5 class="p-2 text-center nomInfo">{{ Auth::user()->nombre . " " . Auth::user()->apellido }}</h5>
                                    <a class="dropdown-item" href="{{ route('usuario.perfil') }}"><span class="font-icon glyphicon glyphicon-user"></span>Perfil</a>
                                    <a class="dropdown-item" href="{{ route('usuario.cambiarClave') }}"><span class="font-icon glyphicon glyphicon-lock"></span>Cambiar contraseña</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <span class="font-icon glyphicon glyphicon-log-out"></span>Salir
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <nav class="side-menu">
            <ul class="side-menu-list p-0">
                <li class="red">
                    <a href="{{route('home')}}" class="{{ Request::is('home*') ? 'activo' : ''}}">
                        <img src="{{asset('img-inicio/house.png')}}" class="img-inicio"> <span class="lbl">INICIO</span>
                    </a>
                </li>
                <li class="grey with-sub {{ Request::is('productos*') || Request::is('categoria*') ? 'opened' : ''}}">
                    <span>
                        <img src="{{asset('img-inicio/boton-agregar.png')}}" class="img-inicio"> 
                        <span class="lbl">REGISTROS</span>
                    </span>
                    <ul>
                        <li>
                            <a href="{{route('categoria.index')}}" class="{{ Request::is('categoria*') ? 'activo' : ''}}">
                                <i class="fas fa-tags"></i> <span class="lbl">CATEGORÍA</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('productos.index')}}" class="{{ Request::is('productos*') ? 'activo' : ''}}">
                                <i class="fas fa-th-list"></i> <span class="lbl">PRODUCTOS</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="red">
                    <a href="{{route('usuario.index')}}" class="{{ Request::is('usuario*') ? 'activo' : ''}}">
                        <img src="{{asset('img-inicio/user.png')}}" class="img-inicio"> <span class="lbl">USUARIOS</span>
                    </a>
                </li>
                
                <li class="red">
                    <a href="{{route('empresa.index')}}" class="{{ Request::is('empresa*') ? 'activo' : ''}}">
                        <img src="{{asset('img-inicio/info.png')}}" class="img-inicio"> <span class="lbl">ACERCA DE</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="page-content mt-5">
            @yield('content')
        </div>
    </div>

    {{-- JS Base --}}
    <script src="{{asset('app/publico/js/lib/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('bootstrap5/js/popper.min.js')}}"></script>
    <script src="{{asset('bootstrap5/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('app/publico/js/lib/tether/tether.min.js')}}"></script>
    <script src="{{asset('app/publico/js/lib/bootstrap/bootstrap.min.js')}}"></script>
    <script src="{{asset('app/publico/js/plugins.js')}}"></script>

    {{-- DataTables JS --}}
    <script src="{{asset('app/publico/js/lib/datatables-net/datatables.min.js')}}"></script>

    {{-- Sweet Alert & PNotify --}}
    <script src="{{asset('sweet/js/sweetalert2.js')}}"></script>
    <script src="{{asset('pnotify/js/pnotify.js')}}"></script>
    <script src="{{asset('pnotify/js/pnotify.buttons.js')}}"></script>
    
    <script type="text/javascript" src="{{asset('app/publico/js/lib/jqueryui/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('app/publico/js/lib/lobipanel/lobipanel.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('app/publico/js/lib/match-height/jquery.matchHeight.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('app/publico/js/lib/jquery-flex-label/jquery.flex.label.js')}}"></script>

    <script src="{{asset('app/publico/js/app.js')}}"></script>

    {{-- Alertas de Sesión --}}
    <script>
        $(function() {
            @if (session('CORRECTO') || session('correcto'))
                new PNotify({
                    title: 'ÉXITO',
                    text: "{{ session('CORRECTO') ?? session('correcto') }}",
                    type: 'success',
                    styling: 'bootstrap3'
                });
            @endif
            @if (session('INCORRECTO') || session('incorrecto'))
                new PNotify({
                    title: 'ERROR',
                    text: "{{ session('INCORRECTO') ?? session('incorrecto') }}",
                    type: 'error',
                    styling: 'bootstrap3'
                });
            @endif
            
            $('.fl-flex-label').flexLabel();
        });
    </script>

    {{-- Aquí se inyectarán los scripts de cada vista (como los de DataTables) --}}
    @stack('scripts')

</body>
</html>