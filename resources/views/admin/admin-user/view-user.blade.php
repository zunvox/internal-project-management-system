<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User View User(Admin) — Syedn Tech Solution</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
 
  .page{
    max-width:1100px;
    margin:0 auto;
    padding:16px 24px 64px;
    height: 900px;
  }
 
  .back-link{
    display:inline-block;
    font-size:15px;
    color:#101828;
    text-decoration:none;
    margin-bottom:16px;
  }
 
  .back-link:hover{
    text-decoration:none;
    font-weight: 600;
  }
 
  /* Profile card */
 
  .profile-card{
    background:white;
    border:1px solid #2B6FFF;
    border-radius:14px;
    padding:28px 32px 36px;
    box-shadow:0 20px 50px rgba(43,111,255,0.18);
  }
 
  .card-title{
    font-size:24px;
    font-weight:800;
    margin:0 0 16px;
  }
 
  .section-label{
    font-size:18px;
    font-weight:700;
    margin:0 0 16px;
  }
 
  hr.divider{
    border:none;
    border-top:1px solid #E4E7EC;
    margin:0 -32px 30px;
  }
 
  /* Profile picture section */
  .profile-picture-row{
    display:flex;
    align-items:center;
    gap:16px;
    margin-bottom:24px;
  }
 
  .profile-avatar-lg{
    width:92px;
    height:92px;
    min-width:56px;
    border-radius:50%;
    border:2px solid black;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow: hidden;
  }

  .profile-image{
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
 
  .profile-name-row{
    display:flex;
    align-items:center;
    gap:10px;
  }
 
  .profile-name-row .name{
    font-size:25px;
    font-weight:700;
  }
 
  .role-badge{
    background:#A3EBFF;
    border:2px solid #0B3453;
    color:#0F7FB0;
    font-size:11px;
    font-weight:700;
    letter-spacing:0.05em;
    text-transform:uppercase;
    padding:4px 12px;
    border-radius:5px;
  }
 
  .member-since{
    font-size:12px;
    color:#98A2B3;
    margin-top:4px;
  }
 
  /* Personal info grid */
  .info-grid{
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    column-gap:40px;
    row-gap:28px;
  }
 
  .info-field{
    display:flex;
    flex-direction:column;
    gap:8px;
  }
 
  .info-field .label{
    font-size:14px;
    color:#98A2B3;
  }
 
  .info-field .value{
    font-size:16px;
    color:#101828;
    line-height:1.5;
  }
 
  .field-full-name{ grid-column:1; }
  .field-user-id{ grid-column:2; }
  .field-email{ grid-column:3; }
  .field-username{ grid-column:4; }
 
  .field-role{ grid-column:1; }
  .field-phone{ grid-column:2; }
  .field-address{ grid-column:3 / span 2; }
 
  .field-status{ grid-column:1; }
 
  .card-actions{
    display:flex;
    justify-content:flex-end;
    margin-top:28px;
  }
 
  .btn{
    padding:10px 28px;
    border-radius:5px;
    font-size:14px;
    font-weight:600;
    cursor:pointer;
    background:white;
  }
 
  .btn-update{
    border:1px solid #019BEF;
    color:#019BEF;
    text-decoration: none;
  }
 
  .btn-update:hover{
    background:#EFF4FF;
  }
 
</style>

</head>

<body>
    @include('admin.partials.admin-topbar')
    @include('admin.partials.admin-nav')

<div class ="stage"> 
  <div class="page">
    <a class="back-link" href="{{  route('admin.users.index') }}">&larr; Back to Manage User</a>
    
    <div class="profile-card">
        <h1 class="card-title">User Profile</h1>
        
        <hr class ="divider">
        <h2 class="section-label">Profile Picture</h2>
    
        <div class="profile-picture-row">

          <div class="profile-avatar-lg">
            @if ($user->profile_picture)
            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="profile-image">
          @else
            {{ strtoupper(substr($user->username ?: $user->fullname, 0, 1)) }}
          @endif</div>

          <div>
              <div class="profile-name-row">
                <span class="name">{{  $user->username ?: $user->fullname }}</span>
                <span class="role-badge">{{  $user->role }}</span>
              </div>
            <div class="member-since">Member since {{ $user->created_at->format('F Y') }}</div>
          </div>
        </div>
    
        <h2 class="section-label">Personal Info</h2>
        <hr class="divider">
    
        <div class="info-grid">
          <div class="info-field field-full-name">
              <span class="label">Full Name</span>
              <span class="value">{{ $user->fullname}}</span>
          </div>
      
          <div class="info-field field-user-id">
              <span class="label">{{ $user->role === 'Admin' ? 'Admin ID' : 'Developer ID' }}</span>
              <span class="value">{{ $user->userid }}</span>
          </div>
      
          <div class="info-field field-email">
              <span class="label">Email Address</span>
              <span class="value">{{  $user->email }}</span>
          </div>
      
          <div class="info-field field-username">
              <span class="label">Username</span>
              <span class="value">{{  $user->username }}</span>
          </div>
      
          <div class="info-field field-role">
              <span class="label">Role</span>
              <span class="value">{{ $user->role }}</span>
          </div>
      
          <div class="info-field field-phone">
              <span class="label">Phone Number</span>
              <span class="value">{{ $user->phone ?: '-' }}</span>
          </div>
      
          <div class="info-field field-address">
              <span class="label">Address</span>
              <span class="value">{{ $user->address }}</span>
          </div>
      
          <div class="info-field field-status">
              <span class="label">Status</span>
              <span class="value">{{ $user->status }}</span>
          </div>
        </div>
    
        <div class="card-actions">
          <a href="{{  route('admin.users.edit', $user) }}" class="btn btn-update">Update</a>
        </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function()
{
    const profileImage = document.querySelector('.profile-image');

    if(profileImage)
    {
      profileImage.addEventListener('error',function()
      {
        this.style.display = 'none';
      });
    }
});

  </script>

</body>

</html>