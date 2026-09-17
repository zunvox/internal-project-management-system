<nav class="navbar">

    <ul class="nav-list">

        <li class="nav-item {{ request()->routeIs('developer.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('developer.dashboard') }}">Dashboard</a>
        </li>

        <li class="nav-item {{ request()->routeIs('developer.projects.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('developer.projects.index') }}">My Projects</a>
        </li>

        <li class="nav-item {{ request()->routeIs('developer.invoices.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('developer.invoices.index') }}">My Invoices</a>
        </li>

        <li class="nav-item {{ request()->routeIs('developer.claims.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('developer.claims.index') }}">My Claims</a>
        </li>

    </ul>

</nav>
