<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit User(Admin) — Syedn Tech Solution</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>

     
  .page{
    max-width:1100px;
    margin:0 auto;
    padding:16px 24px 64px;
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
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
  }
 
  .profile-avatar-lg{
    width: 92px;
    height: 92px;
    min-width: 92px;
    border-radius: 50%;
    border: 2px solid black;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }

  .profile-image{
    width:100%;
    height:100%;
    object-fit:cover;
  }
 
  .profile-name-row{
    display:flex;
    align-items: center;
    gap: 10px;
  }
 
  .profile-name-row .name{
    font-size:25px;
    font-weight:700;
  }

  .change-photo-wrapper{
    margin-left:auto;
  }

  .btn-change-photo{
    padding:8px 18px;
    background:white;
    border:1px solid #019BEF;
    color:#019BEF;
    border-radius:5px;
    font-size:14px;
    font-weight:600;
    cursor:pointer;
  }

  .btn-change-photo:hover{
    background: #EFF4FF;
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
 
  /* Personal info update grid */
  .form-grid{
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    column-gap:40px;
    row-gap:36px;
  }
 
  .form-field{
    display:flex;
    flex-direction:column;
    gap:10px;
  }
 
  .form-field .label{
    font-size:14px;
    font-weight: 700;
    color:#98A2B3;
  }
 
  .form-field .value{
    font-size:16px;
    color:#101828;
    line-height:1.5;
  }

  .form-field input,
  .form-field select,
  .form-field textarea{
    width:100%;
    padding: 10px 14px;
    font-size: 13px;
    font-family: 'Inter',system-ui,sans-serif;
    color: black;
    background-color:#ffffff;
    border:1px solid #D0D5DD;
    border-radius: 10px;
    outline: none;
    transition:border-color 0.15s ease, box-shadow 0.15s ease;
  }

  .form-field textarea{
    resize:vertical;
    min-height: 64px;
    font-family:'Inter',system-ui,sans-serif;
  }

  .form-field input:focus,
  .form-field select:focus,
  .form-field textarea:focus{
    border-color:#3538CD;
    box-shadow:0 0 0 4px rgba(53, 56, 205, 0.14);
  }
 
  .field-full-name{ grid-column:1; }
  .field-dev-id{ grid-column:2; }
  .field-email{ grid-column:3; }
  .field-username{ grid-column:4; }
 
  .field-role{ grid-column:1; }
  .field-phone{ grid-column:2; }
  .field-address{ grid-column:3 / span 2; }

  .field-status{ grid-column:1; }

 
  .card-actions{
    grid-column: 1 / -1;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 28px;
  }
 
  .btn{
    padding: 10px 28px;
    border-radius: 5px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    background: white;
  }

  .btn-cancel{
    padding: 10px 45px;
    text-decoration: none;
    border: 1px solid #DC0000;
    color: #DC0000;
  }

  .btn-cancel:hover{
    background: #ffdfdf;
  }
 
  .btn-update{
    border: 1px solid #019BEF;
    color:#019BEF;
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
    
    <div class="profile-card">
      <form id="edit-user-form" method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data">

          @csrf
          @method('PUT')

        <h1 class="card-title">User Profile</h1>
        
        <hr class ="divider">
        <h2 class="section-label">Profile Picture</h2>
    
        <div class="profile-picture-row">

            <div class="profile-avatar-lg">
              @if ($user->profile_picture)
                <img id="profile-preview" src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="profile-image">
              @else
              <div id="profile-initial">
                {{ strtoupper(substr($user->username ?: $user->fullname, 0, 1)) }}
              </div>

              <img id="profile-preview" src="" alt="Profile Preview" class="profile-image" style="display:none;">
              @endif
            </div>

            <div>
              <div class="profile-name-row">
                <span class="name">{{ $user->username ?: $user->fullname}}</span>
                <span class="role-badge">{{ $user->role }}</span>
              </div>

              <div class="member-since">Member since {{ $user->created_at->format('F Y') }}</div>
            </div>

            <div class="change-photo-wrapper">
              <input id="profile-picture-input" type="file" name="profile_picture" accept=".jpg,.jpeg,.png,.webp" hidden>

              <button type="button" class="btn-change-photo" id="change-photo-btn">Change Photo</button>
            </div>
        </div>
    
        <h2 class="section-label">Personal Info</h2>
        <hr class="divider">
    
        <div class="form-grid">
          <div class="form-field field-full-name">
              <label for="full_name">Full Name</label>
                  <input id="full_name" name="fullname" type="text" value="{{  old('fullname', $user->fullname) }}">
          </div>
      
          <div class="form-field field-dev-id">
              <label for="dev_id" id="user-id-label">{{  $user->role === 'Admin' ? 'Admin ID' : 'Developer ID' }}</label>
                  <input id="dev_id" name="userid" type="text" value="{{  old('userid', $user->userid) }}">
          </div>
      
          <div class="form-field field-email">
            <label for="email">Email Address</label>
                  <input id="email" name="email" type="email" value="{{  old('email', $user->email) }}">
          </div>
      
          <div class="form-field field-username">
            <label for="username">Username</label>
                  <input id="username" name="username" type="text" value="{{  old('username', $user->username) }}">
          </div>
      
          <div class="form-field field-role">
            <label for="role">Role</label>
                  <select id="role" name="role" required>
                  <option value="Developer"{{ old('role', $user->role) === 'Developer' ? 'selected' : '' }}>Developer</option>
                  <option value="Admin"{{ old('role', $user->role) === 'Admin' ? 'selected' : '' }}>Admin</option>
                  </select>
          </div>
      
          <div class="form-field field-phone">
            <label for="phone">Phone Number</label>
                  <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}">
          </div>
      
          <div class="form-field field-address">
              <label for="address">Address</label>
                  <textarea id="address" name="address">{{old('address', $user->address)}}</textarea>
          </div>

          <div class="form-field field-status">
            <label for="status">Status</label>
            <select id="status" name="status" required>
              <option value="Active" {{ old('status', $user->status) === 'Active' ? 'selected' : '' }}>Active</option>
              <option value="Inactive" {{ old('status', $user->status) === 'Inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
          </div>
        </div>
    
        <div class="card-actions">
        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-cancel">Cancel</a>
        <button type="submit" class="btn btn-update">Save Changes</button>
        </div>
      </form>
    </div>
</div>

<script>
  const changePhotoBtn = document.getElementById('change-photo-btn');
  const profilePictureInput = document.getElementById('profile-picture-input');
  const profilePreview = document.getElementById('profile-preview');
  const profileInitial = document.getElementById('profile-initial');
  const roleSelect = document.getElementById('role');
  const userIdLabel = document.getElementById('user-id-label');
  const editUserForm = document.getElementById('edit-user-form');

  roleSelect.addEventListener('change', function()
  {
    if (this.value === 'Admin')
    {
        userIdLabel.textContent = "Admin ID";
    }
    else
    {
      userIdLabel.textContent = "Developer ID";
    }
  });

  editUserForm.addEventListener('submit', function(event)
  {
    const confirmed = confirm("Are you sure you want to update this user's information?");
    
    if (!confirmed)
    {
      event.preventDefault();
    }
  });

  changePhotoBtn.addEventListener('click', function () 
  {
    profilePictureInput.click();
  });

  profilePictureInput.addEventListener('change', function () 
  {
      const file = this.files[0];

      if (file) 
      {
          const imageUrl = URL.createObjectURL(file);

          profilePreview.src = imageUrl;
          profilePreview.style.display = 'block';

          if (profileInitial) 
          {
              profileInitial.style.display = 'none';
          }
        }
  });

  </script>

</body>

</html>