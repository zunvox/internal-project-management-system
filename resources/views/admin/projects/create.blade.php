<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create New Project</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>

  /*Page layout*/

  .stage{
    width:100%;
    max-width:none;
}

  .page{
    width:100%;
    margin:0 auto;
    padding:20px 24px 64px;
  }

  .breadcrumb{
    font-size:13px;
    color:#98A2B3;
    margin-bottom:6px;
  }

  .breadcrumb .current{
    color:#101828;
    font-weight:700;
  }

  .page-title{
    font-size:28px;
    font-weight:800;
    margin:0 0 20px;
  }

  .columns{
    display:grid;
    grid-template-columns:1.4fr 1fr;
    gap:24px;
    align-items:start;
  }

  .card{
    background:white;
    border:1px solid #2B6FFF;
    border-radius:14px;
    box-shadow:0 20px 50px rgba(43,111,255,0.18);
  }

  .card-header{
    padding:18px 24px;
    border-bottom:1px solid #E4E7EC;
  }

  .card-header h2{
    font-size:17px;
    font-weight:700;
    margin:0;
  }

  /* ---------- Project information form ---------- */

  .card-body{
    padding:22px 24px 26px;
  }

  .form-field{
    display:flex;
    flex-direction:column;
    gap:8px;
    margin-bottom:22px;
  }

  .form-field label{
    font-size:14px;
    font-weight:700;
    color:#101828;
  }

  .form-field input,
  .form-field textarea{
    width:100%;
    padding:10px 14px;
    font-size:13px;
    font-family:'Inter',system-ui,sans-serif;
    color:black;
    background-color:#ffffff;
    border:1px solid #D0D5DD;
    border-radius:10px;
    outline:none;
    transition:border-color 0.15s ease, box-shadow 0.15s ease;
  }

  .form-field textarea{
    resize:vertical;
    min-height:70px;
    font-family:'Inter',system-ui,sans-serif;
  }

  .form-field input:focus,
  .form-field textarea:focus{
    border-color:#3538CD;
    box-shadow:0 0 0 4px rgba(53, 56, 205, 0.14);
  }

  .date-row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
  }

  .date-input-wrap{
    position:relative;
  }

  .date-input-wrap input{
    padding-right:36px;
  }

  /* ---------- Developer assignment ---------- */

  .search-field{
    position:relative;
    margin:18px 24px 0;
  }

  .search-field svg{
    position:absolute;
    left:12px;
    top:50%;
    transform:translateY(-50%);
    width:15px;
    height:15px;
    fill:#98A2B3;
  }

  .search-field input{
    width:100%;
    padding:9px 12px 9px 34px;
    font-size:13px;
    font-family:'Inter',system-ui,sans-serif;
    border:1px solid #D0D5DD;
    border-radius:10px;
    outline:none;
    background:#F9FAFB;
  }

  .search-field input::placeholder{
    color:#98A2B3;
  }

  .search-field input:focus{
    border-color:#3538CD;
    box-shadow:0 0 0 4px rgba(53, 56, 205, 0.14);
    background:white;
  }

  .dev-list{
    max-height:280px;
    overflow-y:auto;
    margin:14px 4px 0 24px;
    padding-right:10px;
  }

  .dev-list::-webkit-scrollbar{
    width:8px;
  }

  .dev-list::-webkit-scrollbar-track{
    background:#F2F4F7;
    border-radius:8px;
  }

  .dev-list::-webkit-scrollbar-thumb{
    background:#98A2B3;
    border-radius:8px;
  }

  .dev-item{
    display:flex;
    align-items:center;
    gap:12px;
    padding:10px 12px;
    border-radius:8px;
    cursor:pointer;
  }

  .dev-item.selected{
    background:#EAF0FF;
  }

  .dev-item:hover{
    background:#F5F8FF;
  }

  .dev-checkbox{
    width:18px;
    height:18px;
    accent-color:#2B6FFF;
    cursor:pointer;
  }

  .dev-avatar{
    width:32px;
    height:32px;
    min-width:32px;
    border-radius:50%;
    border:2px solid black;
    display:flex;
    align-items:center;
    justify-content:center;
  }

  .dev-avatar svg{
    width:18px;
    height:18px;
    fill:black;
  }

  .dev-info .dev-name{
    font-size:14px;
    font-weight:600;
    color:#101828;
  }

  .dev-footer{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:14px 24px 20px;
  }

  .selected-summary{
    font-size:12px;
    color:#667085;
  }

  .dev-actions{
    display:flex;
    align-items:center;
    gap:16px;
  }

  .link-cancel{
    font-size:13px;
    font-weight:600;
    color:#2B6FFF;
    background:none;
    border:none;
    cursor:pointer;
    text-decoration:none;
  }

  .btn-confirm{
    background:#2B6FFF;
    color:white;
    border:none;
    padding:9px 22px;
    border-radius:999px;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
    box-shadow:0 4px 14px rgba(43,111,255,0.35);
  }

  .btn-confirm:hover{
    background:#1f5ae0;
  }

</style>
</head>
<body>
    
    @include('admin.partials.admin-topbar')
    @include('admin.partials.admin-nav')

<div class = "stage">
    <div class="page">

        <div class="breadcrumb">Projects &gt; <span class="current">Create New Project</span></div>
        <h1 class="page-title">Create New Project</h1>

            <form action="{{ route('admin.projects.store') }}" method="POST" id="create-project-form">
            @csrf

            <div class="columns">

                <!-- Project Information -->
                <div class="card">
                <div class="card-header">
                    <h2>Project Information</h2>
                </div>

                <div class="card-body">
                    <div class="form-field">
                        <label for="project_name">Project Name</label>
                        <input id="project_name" name ="name" type="text" value="{{  old('name') }}" placeholder="Enter project name" required>
                    </div>

                    <div class="date-row">
                    <div class="form-field">
                        <label for="start_date">Start Date</label>
                        <div class="date-input-wrap">
                            <input id="start_date" name="start_date" type="date" value="{{  old('start_date') }}" required>
                        </div>
                    </div>

                    <div class="form-field">
                        <label for="end_date">End Date</label>
                        <div class="date-input-wrap">
                            <input id="end_date" name="end_date" type="date" value="{{  old('end_date') }}" required>
                        </div>
                    </div>
                    </div>

                    <div class="form-field" style="margin-bottom:0;">
                    <label for="description">Project Description</label>
                        <textarea id="description" name="description" placeholder="Enter project description">{{  old('description') }} </textarea>
                    </div>
                </div>
                </div>

                <!-- Developer Assignment -->
                <div class="card">
                <div class="card-header">
                    <h2>Developer Assignment</h2>
                </div>

                <div class="search-field">
                    <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27a6.47 6.47 0 0 0 1.57-4.23 6.5 6.5 0 1 0-6.5 6.5c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5Zm-6 0A4.5 4.5 0 1 1 14 9.5 4.5 4.5 0 0 1 9.5 14Z"/></svg>
                    <input id="developer-search" type="text" placeholder="Search developers by name">
                </div>

                <div class="dev-list">

                    @forelse ($developers as $developer)

                        <label class="dev-item" data-name="{{ strtolower($developer->fullname) }}">

                            <input class="dev-checkbox" type="checkbox" name="developers[]" value="{{ $developer->id }}" data-developer-name="{{ $developer->fullname }}" {{ in_array($developer->id, old('developers', [])) ? 'checked' : '' }}>

                            <span class="dev-avatar">
                                 {{ strtoupper(substr($developer->fullname, 0, 1)) }}
                            </span>
                            
                            <span class="dev-info">
                                <div class="dev-name">{{ $developer->fullname }}</div>
                            </span>

                        </label>
                    @empty
                    
                        <p class="no-developers">No active developers available.</p>
                    
                    @endforelse

                </div>

                    <div class="dev-footer">
                        <span class="selected-summary" id="selected-summary">0 Developer selected</span>

                        <div class="dev-actions">
                            <a href="{{ route('admin.projects.index') }}" class="link-cancel">Cancel</a>
                            <button class="btn-confirm" type="submit">Confirm</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function()
{
    const searchInput = document.getElementById('developer-search');
    const developerItems = document.querySelectorAll('.dev-item');
    const checkboxes = document.querySelectorAll('.dev-checkbox');
    const selectedSummary = document.getElementById('selected-summary');

    function updateSelectedDevelopers()
    {
        const selected = [];

        checkboxes.forEach(function (checkbox)
    {
        const item = checkbox.closest('.dev-item');

        if (checkbox.checked)
        {
            item.classList.add('selected');

            selected.push(checkbox.dataset.developerName);
        }
        else{
            item.classList.remove('selected');
        }
    });

    if (selected.length === 0 )
    {
        selectedSummary.textContent = '0 Developers selected';
    }
    else{
        selectedSummary.textContent = selected.length + (selected.length === 1 ? ' Developer selected -' : ' Developers selected -') + selected.join(',');
    }
}

    checkboxes.forEach(function (checkbox)
    {
            checkbox.addEventListener('change', function()
        {
            updateSelectedDevelopers();
        });
    });

    searchInput.addEventListener('input', function () {
        
        const searchValue = searchInput.value.toLowerCase().trim();

        developerItems.forEach(function (item) 
        {
            const developerName = item.dataset.name;

            if (developerName.includes(searchValue)) 
            {
                item.style.display = 'flex';
            } 
            else {
                item.style.display = 'none';
            }
        });
    });
    updateSelectedDevelopers();
});
</script>

</body>
</html>