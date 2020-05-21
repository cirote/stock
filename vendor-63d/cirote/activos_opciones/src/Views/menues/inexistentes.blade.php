<li class="header">OPCIONES</li>
<li class="{{ Request::routeIs('opciones.index') ? "active" : "" }}">
    <a href="{{ route('opciones.index', [], false) }}">
        <i class="fa fa-table"></i> <span>Lista de opciones</span>
    </a>
</li>
<li class="{{ Request::routeIs('inexistentes.index') ? "active" : "" }}">
    <a href="{{ route('inexistentes.index', [], false) }}">
        <i class="fa fa-medkit"></i> <span>Tickers inexistentes</span>
    </a>
</li>
