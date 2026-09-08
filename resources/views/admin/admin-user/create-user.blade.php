<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add User(Admin) — Syedn Tech Solution</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>

  /* Page layout */

  .page{
    max-width:1100px;
    margin:0 auto;
    padding:32px 24px 64px;
  }

  .page-title{
    font-size:26px;
    font-weight:800;
    margin:0 0 20px;
  }

  /* Summary card */

  .summary-card{
    background:white;
    border:1px solid #2B6FFF;
    border-radius:14px;
    padding:20px 24px;
    margin-bottom:24px;
  }

  .summary-top{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:16px;
  }

  .summary-name{
    font-size:18px;
    font-weight:700;
  }

  .summary-separator{
    font-size:16px;
    font-weight:400;
    color:#475467;
  }

  .summary-id{
    font-size:16px;
    font-weight:400;
    color:#475467;
  }

  .role-badge{
    background:#A3EBFF;
    border:2px solid #0B3453;
    color:#0B3453;
    font-size:11px;
    font-weight:700;
    letter-spacing:0.05em;
    text-transform:uppercase;
    padding:4px 12px;
    border-radius:5px;
  }

  .summary-body{
    display:flex;
    gap:24px;
  }

  .summary-avatar{
    width:92px;
    height:92px;
    min-width:72px;
    border-radius:50%;
    border:2px solid black;
    display:flex;
    align-items:center;
    justify-content:center;
  }

  .summary-avatar svg{
    width:44px;
    height:44px;
    fill:black;
  }

  .summary-details{
    display:grid;
    grid-template-columns:150px 1fr;
    row-gap:6px;
    column-gap:8px;
    font-size:14px;
    align-content:center;
  }

  .summary-details dt{
    font-weight:700;
    color:#101828;
  }

  .summary-details dd{
    margin:0;
    color:#101828;
  }

/* Validation error */

  .validation-errors{
    background:#FEF3F2;
    border:1px solid #F04438;
    color:#B42318;
    padding:12px 16px;
    border-radius:10px;
    margin-bottom:16px;
}

.validation-errors ul{
    margin:0;
    padding-left:20px;
}

  /* Form card */

  .form-card{
    background:white;
    border:1px solid #2B6FFF;
    border-radius:14px;
    padding:32px;
    box-shadow:0 20px 50px rgba(43,111,255,0.18);
  }

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

  .form-field label{
    font-size:14px;
    font-weight:700;
    color:#101828;
  }

  .form-field input,
  .form-field select,
  .form-field textarea{
    width:100%;
    padding:10px 14px;
    font-size:13px;
    font-family: 'Inter',system-ui,sans-serif;
    color:black;
    background-color:#ffffff;
    border:1px solid #D0D5DD;
    border-radius:10px;
    outline:none;
    transition:border-color 0.15s ease, box-shadow 0.15s ease;
  }

  .form-field input:disabled{
    background-color:#EAECF0;
    color:#475467;
  }

  .form-field textarea{
    resize:vertical;
    min-height:64px;
    font-family:'Inter',system-ui,sans-serif;
  }

  .form-field input:focus,
  .form-field select:focus,
  .form-field textarea:focus{
    border-color:#3538CD;
    box-shadow:0 0 0 4px rgba(53, 56, 205, 0.14);
  }

  .field-full-name{ grid-column:1; }
  .field-user-id{ grid-column:2; }
  .field-username{ grid-column:3; }
  .field-role{ grid-column:4; }

  .field-email{ grid-column:1; }
  .field-phone{ grid-column:2; }
  .field-password{ grid-column:3; }
  .field-status{ grid-column:4; }
  
  .field-address{ grid-column:1 / span 2; }
  .field-password-confirmation{ grid-column:3; }

  .form-actions{
    grid-column:1 / -1;
    display:flex;
    justify-content:flex-end;
    gap:12px;
    margin-top:8px;
  }

  .password-wrapper{
    position:relative;
    width:100%;
  }

  .password-wrapper input{
      width:100%;
      padding-right:44px;
      box-sizing:border-box;
  }

  .password-toggle{
      position:absolute;
      right:12px;
      top:50%;
      transform:translateY(-50%);

      border:none;
      background:none;
      padding:4px;
      cursor:pointer;
      font-size:16px;

      display:flex;
      align-items:center;
      justify-content:center;
  }

  .btn{
    padding:10px 38px;
    border-radius: 10px;
    font-size:14px;
    font-weight:600;
    cursor:pointer;
    background:white;
  }

  .btn-cancel{
    border:1px solid #F04438;
    text-decoration:none;
    color:#F04438;
  }

  .btn-cancel:hover{
    background:#FEF3F2;
  }

  .btn-create{
    border:1px solid #019BEF;
    color:#019BEF;
  }

  .btn-create:hover{
    background:#EFF4FF;
  }

</style>

</head>

<body>
    @include('admin.partials.admin-topbar')
    @include('admin.partials.admin-nav')

<div class = "stage">
  <div class="page">
        <h1 class="page-title">Add New User</h1>

        <div class="summary-card">
            <div class="summary-top">
              <span class="summary-name" id="summary-name">Username</span>
              <span class="summary-separator">|</span>
              <span class="summary-id" id="summary-id"></span>
              <span class="role-badge" id="summary-role">Developer</span>
            </div>

            <div class="summary-body">
            <div class="summary-avatar" id="summary-avatar">?</div>

              <dl class="summary-details">
                  <dt>Full Name</dt>
                  <dd id="summary-fullname">: -</dd>

                  <dt>Phone Number</dt>
                  <dd id="summary-phone">: -</dd>

                  <dt>Email Address</dt>
                  <dd id="summary-email">: -</dd>

                  <dt>Address</dt>
                  <dd id="summary-address">: -</dd>
              </dl>
            </div>
        </div>

        <form id="create-user-form" method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data" autocomplete="off">
          @csrf

          @if ($errors->any())
            <div class="validation-errors">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="form-card">
              <div class="form-grid">

              <div class="form-field field-full-name">
                  <label for="full_name">Full Name</label>
                  <input id="full_name" name="fullname" type="text" value="{{  old('fullname') }}" required>
              </div>

              <div class="form-field field-user-id">
                  <label for="dev_id" id="user-id-label"> {{ old('role') === 'Admin' ? 'Admin ID' : 'Developer ID' }} </label>
                  <input id="dev_id" name="userid" type="text" value="{{  old('userid') }}" required>
              </div>

              <div class="form-field field-username">
                  <label for="username">Username</label>
                  <input id="username" name="username" type="text" value="{{ old('username') }}" autocomplete="off">
              </div>

              <div class="form-field field-role">
                  <label for="role">Role</label>
                  <select id="role" name="role" required>
                  <option value="Developer" {{ old('role', 'Developer') === 'Developer' ? 'selected' : '' }}>Developer</option>
                  <option value="Admin" {{ old('role') === 'Admin' ? 'selected' : '' }}>Admin</option>
                  </select>
              </div>

              <div class="form-field field-email">
                  <label for="email">Email Address</label>
                  <input id="email" name="email" type="email" value="{{  old('email') }}" required>
              </div>

              <div class="form-field field-phone">
                  <label for="phone">Phone Number</label>
                  <input id="phone" name="phone" type="text" value="{{ old('phone') }}">
              </div>

              <div class="form-field field-password">
                  <label for="password">Password</label>
                  <div class="password-wrapper">
                    <input id="password" name="password" type="password" autocomplete="new-password" required>
                    <button type="button" class="password-toggle" data-target="password" aria-label="Show password">👁</button>
                  </div>
              </div>

              <div class="form-field field-status">
                  <label for="status">Status</label>
                  <select id="status" name="status" required>
                  <option value="Active" {{ old('status', 'Active') === 'Active' ? 'selected' : '' }}>Active</option>
                  <option value="Inactive" {{ old('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                  </select>
              </div>

              <div class="form-field field-address">
                  <label for="address">Address</label>
                  <textarea id="address" name="address">{{ old('address') }}</textarea>
              </div>

              <div class="form-field field-password-confirmation">
                  <label for="password_confirmation">Confirm Password</label>
                  <div class="password-wrapper">
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>
                    <button type="button" class="password-toggle" data-target="password_confirmation" aria-label="Show password">👁</button>
                  </div>

                  @error('password')
                      <span class="field-error">{{ $message }}</span>
                  @enderror

              </div>

              <div class="form-actions">
                  <a href="{{ route('admin.users.index') }}" class="btn btn-cancel">Cancel</a>
                  <button type="submit" class="btn btn-create">Create</button>
              </div>
            </div>
          </div>
        </form>
  </div>
</div>

<script>
  const roleSelect = document.getElementById('role');
  const userIdLabel = document.getElementById('user-id-label');
  const createUserForm = document.getElementById('create-user-form');
  const passwordToggleButtons = document.querySelectorAll('.password-toggle');

  const fullnameInput = document.getElementById('full_name');
  const useridInput = document.getElementById('dev_id');
  const emailInput = document.getElementById('email');
  const usernameInput = document.getElementById('username');
  const phoneInput = document.getElementById('phone');
  const addressInput = document.getElementById('address');
  const summaryName = document.getElementById('summary-name');
  const summaryId = document.getElementById('summary-id');
  const summaryRole = document.getElementById('summary-role');
  const summaryAvatar = document.getElementById('summary-avatar');    
  const summaryFullname = document.getElementById('summary-fullname');
  const summaryPhone = document.getElementById('summary-phone');
  const summaryEmail = document.getElementById('summary-email');
  const summaryAddress = document.getElementById('summary-address');

    roleSelect.addEventListener('change', function () 
    {
        if (this.value === 'Admin') 
        {
            userIdLabel.textContent = 'Admin ID';
            summaryRole.textContent = 'Admin';
        } 
        else 
        {
            userIdLabel.textContent = 'Developer ID';
            summaryRole.textContent = 'Developer';
        }
    });

    createUserForm.addEventListener('submit', function (event)
    {
      const confirmed = confirm("Are you sure you want to create this user?");

      if (!confirmed)
      {
        event.preventDefault();
      }
    });

    fullnameInput.addEventListener('input', function () 
      {
        summaryFullname.textContent = ': ' + (this.value || '-');
      });

    useridInput.addEventListener('input', function () 
      {
        summaryId.textContent = this.value || 'Developer ID';
      });

    phoneInput.addEventListener('input', function () 
      {
        summaryPhone.textContent = ': ' + (this.value || '-');
      });

    emailInput.addEventListener('input', function () 
      {
        summaryEmail.textContent = ': ' + (this.value || '-');
      });

    addressInput.addEventListener('input', function () 
      {
        summaryAddress.textContent = ': ' + (this.value || '-');
      });

    usernameInput.addEventListener('input', function () 
    {
        const username = this.value.trim();

        summaryName.textContent = username || 'Username';

        if (username) 
        {
          summaryAvatar.textContent = username.charAt(0).toUpperCase();
        } 
        else 
        {
          summaryAvatar.textContent = '?';
        }
    });

    passwordToggleButtons.forEach(function (button) 
    {
      button.addEventListener('click', function () 
      {
          const targetId = this.dataset.target;
          const passwordInput = document.getElementById(targetId);

          if (passwordInput.type === 'password') 
          {
              passwordInput.type = 'text';
              this.setAttribute('aria-label', 'Hide password');
          }
          else 
          {
              passwordInput.type = 'password';
              this.setAttribute('aria-label', 'Show password');
          }
      });
    });



  </script>

</body>

</html>