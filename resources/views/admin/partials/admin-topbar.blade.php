@auth
<div class="topbar">
  <div class="topbar-right">
    <button class="profile-btn" type="button">
      <span class="profile-avatar">{{ strtoupper(substr(auth()->user()->username ?: auth()->user()->fullname, 0, 1)) }}</span>
      <span class="profile-name"> {{ auth()->user()->username ?: auth()->user()->fullname }}</span>
    </button>
  </div>
  <span class="topbar-brand">Syedn Tech Solution</span>
</div>
@endauth