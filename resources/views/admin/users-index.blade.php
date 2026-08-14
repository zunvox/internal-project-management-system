<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User List(Admin) — Syedn Tech Solution</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    /* Page layout */

  body{
    margin:0;
    display:flex;
    flex-direction:column;
    font-family:'Inter',system-ui,sans-serif;
    color:black;
    min-height: 100vh;
  }

  .page{
    width: 100%;
    max-width: 1400px;
    margin:0 auto;
    padding:28px 24px 64px;
    box-sizing:border-box;
  }

  .page-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:20px;
  }

  .page-title{
    font-size:26px;
    font-weight:800;
    margin:0;
  }

  .btn{
    border:none;
    border-radius:10px;
    font-size:14px;
    font-weight:500;
    cursor:pointer;
  }

  .btn-primary{
    background:#019BEF;
    color:white;
    padding: 6px 22px;
    text-decoration:none;
    display:inline-block;
  }

  .btn-primary:hover{
    background:#3db7f8;
  }

  /*Filter bar */

  .filter-bar{
    display:flex;
    align-items:center;
    gap:28px;
    margin-bottom:16px;
    border-bottom:1px solid #E4E7EC;
    border-top:1px solid #E4E7EC;
  }

  .filter-tabs{
    display:flex;
    align-items:center;
    gap:24px;
    flex:1;
  }

  .filter-tab{
    display:flex;
    align-items:center;
    gap:6px;
    background:none;
    border:none;
    padding:10px 0;
    font-size:16px;
    color:#475467;
    cursor:pointer;
    border-bottom:2px solid transparent;
    text-decoration:none;
  }

  .filter-tab:hover{
    color:black;
  }

  .filter-tab.active{
    color:#101828;
    font-weight:700;
    border-bottom:2px solid #2B6FFF;
  }

  .filter-count{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:7px;
    height:20px;
    padding:0 6px;
    border-radius:999px;
    background:#DCEBFF;
    color:#2B6FFF;
    font-size:11px;
    font-weight:700;
  }

  .search-box{
    display:flex;
    align-items:center;
    gap:8px;
    border:1px solid #D0D5DD;
    border-radius:10px;
    padding:4px 16px;
    min-width:220px;
  }

  .search-box svg{
    width:16px;
    height:16px;
    fill:#98A2B3;
  }

  .search-box input{
    border:none;
    outline:none;
    font-size:13px;
    font-family:'Inter',system-ui,sans-serif;
    color:black;
    width:100%;
  }

  .search-box input::placeholder{
    color:#98A2B3;
  }

  .search-box svg{
    width:18px;
    height:18px;

  }

  /*Table card */

  .table-card{
    background:white;
    border:1px solid #2B6FFF;
    border-radius:14px;
    padding:8px 24px 20px;
    box-shadow:0 20px 50px rgba(43,111,255,0.18);
  }

  table{
    width:100%;
    border-collapse:collapse;
  }

  thead th{
    text-align:left;
    font-size:16px;
    font-weight:700;
    color:#101828;
    padding:16px 12px;
    border-bottom:1px solid #E4E7EC;
  }

  thead th:last-child{
    text-align:right;
    padding: 0px 80px;
  }

  tbody td{
    padding:14px 12px;
    font-size:16px;
    color:#101828;
    border-bottom:1px solid #F2F4F7;
  }

  tbody tr:last-child td{
    border-bottom:none;
  }

  thead th:nth-child(1),
  tbody td:nth-child(1){
    width:18%;
  }

  thead th:nth-child(2),
  tbody td:nth-child(2){
    width:40%;
  }

  thead th:nth-child(3),
  tbody td:nth-child(3){
    width:22%;
  }

  thead th:nth-child(4),
  tbody td:nth-child(4){
    width:30%;
  }

  .empty-row{
    text-align:center;
    color:#98A2B3;
    padding:32px 12px;
  }

  .status-badge{
    display:inline-block;
    padding:4px 16px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
  }

  .status-active{
    background:#A3FFB1;
    color:#0B532E;
    padding: 4px 21px;
  }

  .status-inactive{
    background:#C6C6C6;
    color: #012947;
  }

  .col-status{
    display:flex;
    align-items:center;
    justify-content:flex-end;
    gap:12px;
    width:100%;
  }

  .icon-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    width:28px;
    height:28px;
    border:1px solid #D0D5DD;
    border-radius:6px;
    background:white;
    cursor:pointer;
    text-decoration:none;
  }

  .icon-btn:hover{
    background:#F9FAFB;
  }

  .icon-btn svg{
    width:14px;
    height:14px;
    fill:#475467;
}

  /* Pagination */

  .pagination{
    display:flex;
    justify-content:flex-end;
    gap:8px;
    margin-top:16px;
  }

  .page-btn{
    width:28px;
    height:28px;
    border-radius:6px;
    border:1px solid #D0D5DD;
    background:white;
    font-size:13px;
    color:#475467;
    cursor:pointer;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    text-decoration:none;
    box-sizing:border-box;
  }

  .page-btn.active{
    background:#2B6FFF;
    border-color:#2B6FFF;
    color:white;
  }

  .page-btn:disabled{
    opacity:0.4;
    cursor:not-allowed;
  }
</style>

</head>

<body>
    @include('admin.partials.admin-topbar')
    @include('admin.partials.admin-nav')

    <div class="stage">
    <div class="page">

        <div class="page-header">
            <h1 class="page-title">User Management</h1>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Add New User</a>
        </div>

        <div class="filter-bar">
          <div class="filter-tabs">

            <a href="{{ route('admin.users.index', ['search' => request('search')]) }}" 
              class="filter-tab {{  !request('role') && !request('status') ? 'active' : '' }}">All Users<span class="filter-count">{{$allCount}}</span>
            </a>

            <a href="{{ route('admin.users.index', ['role' => 'Developer', 'search' => request('search')]) }}"
              class="filter-tab {{ request('role') === 'Developer' ? 'active' : '' }}">Developer<span class="filter-count">{{$developerCount}}</span>
            </a>

            <a  href="{{ route('admin.users.index', ['role' => 'Admin','search' => request('search')]) }}"
              class="filter-tab {{ request('role') === 'Admin' ? 'active' : '' }}">Admin<span class="filter-count">{{ $adminCount }}</span>
             </a>

            <a href="{{ route('admin.users.index', ['status' => 'Active','search' => request('search')]) }}"
              class="filter-tab {{  request('status') === 'Active' ? 'active' : '' }}">Active<span class="filter-count">{{ $activeCount}}</span>
            </a>

            <a href="{{ route('admin.users.index', ['status' => 'Inactive','search' => request('search')]) }}"
              class="filter-tab {{ request('status') === 'Inactive' ? 'active' : '' }}">Inactive<span class="filter-count">{{$inactiveCount}}</span>
            </a>

          </div>

            <form method="GET" action="{{ route('admin.users.index') }}" class="search-box">
              <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27a6.47 6.47 0 0 0 1.57-4.23 6.5 6.5 0 1 0-6.5 6.5c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5Zm-6 0A4.5 4.5 0 1 1 14 9.5 4.5 4.5 0 0 1 9.5 14Z"/></svg>

              @if (request('role'))
              <input type="hidden" name="role" value="{{  request('role') }}">
              @endif

              @if (request('status'))
               <input type="hidden" name="status" value="{{  request('status') }}">
              @endif

              <input type="text" name="search" value="{{ request('search') }}" placeholder="Search">
            </form>

        </div>

        <div class="table-card">

            <table>
              <thead>
                  <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                  </tr>
              </thead>

              <tbody>

                @forelse ($users as $user)

                  <tr>
                    <td>{{  $user->userid }}</td>
                    <td>{{$user->username ?: $user->fullname}}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                      <div class="col-status">
                        <span class="status-badge {{ $user->status === 'Active' ? 'status-active' : 'status-inactive' }}">{{ $user->status }}</span>
                        <a href="{{ route('admin.users.show', $user) }}" class="icon-btn" title="View User">
                            <svg viewBox="0 0 24 24"><path d="M16 1H4a2 2 0 0 0-2 2v14h2V3h12V1Zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2Zm0 16H8V7h11v14Z"/></svg>
                        </a>
                      </div>
                    </td>
                  </tr>

                  @empty

                  <tr>
                    <td colspan="4" class="empty-row">No users found.</td>
                  </tr>

                  @endforelse

              </tbody>
            </table>

            @if ($users->hasPages())

              <div class="pagination">


              @for ($page = 1; $page <= $users->lastPage(); $page++)
              <a href="{{ $users->url($page) }}" class="page-btn {{  $users->currentPage() === $page ? 'active' : '' }}">{{ $page }}</a>
              @endfor

            @endif
            </div>
        </div>
    </div>
</div>


</body>

</html>