<nav class="navbar">

    <ul class="nav-list">

        <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>

        <li class="nav-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.projects.index') }}">Projects</a>
        </li>

        <li class="nav-item {{ request()->routeIs('admin.payment-vouchers.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.payment-vouchers.index') }}">Payment Voucher</a>
        </li>

        <li class="nav-item {{ request()->routeIs('admin.cash-flows.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.cash-flows.index') }}">Cash Flow</a>
        </li>

        <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.users.index') }}">Manage User</a>
        </li>

    </ul>

</nav>
