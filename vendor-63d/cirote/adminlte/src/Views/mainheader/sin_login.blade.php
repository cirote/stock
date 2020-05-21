<header class="main-header">

    <a href="@yield('navbar_brand_url', '#')" class="logo">
        <span class="logo-mini">@yield('navbar_brand_mini', '')<b>@yield('navbar_brand_mini_bold', '')</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">@yield('navbar_brand', '')<b>@yield('navbar_brand_bold', '')</b></span>
    </a>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Activa la navegación</span>
        </a>

        <div class="navbar-custom-menu">
        </div>

    </nav>
    
</header>