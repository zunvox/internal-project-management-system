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
  .field-dev-id{ grid-column:2; }
  .field-email{ grid-column:3; }
  .field-username{ grid-column:4; }

  .field-role{ grid-column:1; }
  .field-phone{ grid-column:2; }
  .field-status{ grid-column:3; }
  
  .field-address{ grid-column:1 / span 2; }

  .form-actions{
    grid-column:1 / -1;
    display:flex;
    justify-content:flex-end;
    gap:12px;
    margin-top:8px;
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
            <span class="summary-name">AfiqM</span>
            <span class="summary-separator">|</span>
            <span class="summary-id">DEV-00214</span>
            <span class="role-badge">Developer</span>
            </div>

            <div class="summary-body">
            <div class="summary-avatar">A</div>

            <dl class="summary-details">
                <dt>Full Name</dt>
                <dd>: Afiq Muzakkir Bin Azizul Karim</dd>

                <dt>Phone Number</dt>
                <dd>: +60 12-345-6789</dd>

                <dt>Email Address</dt>
                <dd>: afiqmuzakkir@gmail.com</dd>

                <dt>Address</dt>
                <dd>: 144-1, Jalan Burma, 10050, Bandaraya George Town, Pulau Pinang, Malaysia</dd>
            </dl>
            </div>
        </div>

        <div class="form-card">
            <form class="form-grid">
            <div class="form-field field-full-name">
                <label for="full_name">Full Name</label>
                <input id="full_name" type="text" value="Afiq Muzakkir Bin Azizul Karim">
            </div>

            <div class="form-field field-dev-id">
                <label for="dev_id">Developer ID</label>
                <input id="dev_id" type="text" value="DEV-00214">
            </div>

            <div class="form-field field-email">
                <label for="email">Email Address</label>
                <input id="email" type="email" value="afiqmuzakkir@gmail.com">
            </div>

            <div class="form-field field-username">
                <label for="username">Username</label>
                <input id="username" type="text" value="AfiqM">
            </div>

            <div class="form-field field-role">
                <label for="role">Role</label>
                <select id="role">
                <option value="developer" selected>Developer</option>
                <option value="admin">Admin</option>
                </select>
            </div>

            <div class="form-field field-phone">
                <label for="phone">Phone Number</label>
                <input id="phone" type="text" value="+60 12-345-6789">
            </div>

            <div class="form-field field-status">
                <label for="status">Status</label>
                <select id="status">
                <option value="Active" selected>Active</option>
                <option value="Inactive">Inactive</option>
                </select>
            </div>

            <div class="form-field field-address">
                <label for="address">Address</label>
                <textarea id="address">144-1, Jalan Burma, 10050, Bandaraya George Town, Pulau Pinang, Malaysia</textarea>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-cancel">Cancel</button>
                <button type="submit" class="btn btn-create">Create</button>
            </div>
            </form>
        </div>
    </div>
</div>

</body>

</html>