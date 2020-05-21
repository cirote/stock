<!-- Main Header -->
<header class="main-header">
    <!-- Logo -->
    <a href="@yield('navbar_brand_url', '#')" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">@yield('navbar_brand_mini', '')<b>@yield('navbar_brand_mini_bold', '')</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">@yield('navbar_brand', '')<b>@yield('navbar_brand_bold', '')</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Activa la navegación</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Iniciar Sesión</a></li>
                @else
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu" id="user_menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{ asset("img/mercosur_160.png") }}" class="user-image" alt="{{ Auth::user()->first_name }}"/>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs" title="{{ Auth::user()->first_name }}">{{ Auth::user()->first_name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{ asset("img/mercosur_160.png") }}" class="img-circle" alt="{{ Auth::user()->email }}" />
                                <p>
                                    <span data-toggle="tooltip" title="{{ Auth::user()->full_name }}">
                                        {{ Auth::user()->full_name }}
                                    </span>
                                    <small>{{ Auth::user()->email }}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('password.change.form') }}" class="btn btn-default btn-flat">
                                        Cambiar contraseña
                                    </a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-info btn-flat" id="logout" onclick="
                                        event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        Salir
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        <input type="submit" value="logout" style="display: none;">
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                @endif

                {{--<!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>--}}
            </ul>
        </div>
    </nav>
</header>