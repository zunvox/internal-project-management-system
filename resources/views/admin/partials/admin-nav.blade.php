<nav class="navbar">
  <ul class="nav-list">
    <li class="nav-item">
      <a class="nav-link" href="#">Dashboard</a>
    </li>
    <li class="nav-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.projects.index') }}">Projects</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Payment Voucher</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Cash Flow</a>
    </li>
    <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.users.index') }}">Manage User</a>
    </li>
  </ul>
</nav>