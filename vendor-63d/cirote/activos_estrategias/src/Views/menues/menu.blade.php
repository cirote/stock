<li class="header">ESTRATEGIAS</li>
<li class="{{ Request::routeIs('estrategias.lanzamiento_cubierto') ? "active" : "" }}">
    <a href="{{ route('estrategias.lanzamiento_cubierto', [], false) }}">
        <i class="fa fa-rocket"></i> <span>Lanzamiento cubierto</span>
    </a>
</li>
