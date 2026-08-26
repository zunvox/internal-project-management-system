<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Edit Project</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>

  .page{
    max-width:1100px;
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
    margin:0 0 2px;
  }

  .page-subtitle{
    font-size:13px;
    color:#98A2B3;
    margin:0 0 18px;
  }

  .card{
    background:white;
    border:1px solid #2B6FFF;
    border-radius:14px;
    box-shadow:0 20px 50px rgba(43,111,255,0.18);
  }

  .card-header{
    display:flex;
    align-items:baseline;
    justify-content:space-between;
    padding:18px 24px;
  }

  .card-header h2{
    font-size:16px;
    font-weight:700;
    margin:0;
  }

  .card-header .meta{
    font-size:12px;
    color:#98A2B3;
  }

  /* ---------- Project information ---------- */

  .info-card{
    margin-bottom:24px;
  }

  .card-body{
    padding:0 24px 24px;
  }

  .form-field{
    display:flex;
    flex-direction:column;
    gap:8px;
    margin-bottom:20px;
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
    font-family:'Inter',system-ui,sans-serif;
    color:black;
    background-color:#ffffff;
    border:1px solid #D0D5DD;
    border-radius:10px;
    outline:none;
    transition:border-color 0.15s ease, box-shadow 0.15s ease;
  }

  .form-field input:disabled{
    background-color:#D0D5DD;
    color:#475467;
  }

  .form-field textarea{
    resize:vertical;
    min-height:60px;
    font-family:'Inter',system-ui,sans-serif;
  }

  .form-field input:focus,
  .form-field select:focus,
  .form-field textarea:focus{
    border-color:#3538CD;
    box-shadow:0 0 0 4px rgba(53, 56, 205, 0.14);
  }

  .field-row{
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

  .date-input-wrap svg{
    position:absolute;
    right:12px;
    top:50%;
    transform:translateY(-50%);
    width:16px;
    height:16px;
    fill:#667085;
    pointer-events:none;
  }

  /* ---------- Bottom row ---------- */

  .bottom-row{
    display:grid;
    grid-template-columns:1.6fr 1fr;
    gap:24px;
    align-items:start;
  }

  /* ---------- Developer assignment ---------- */

  .assigned-list{
    padding:0 24px;
  }

  .assigned-item{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:10px 12px;
    background:#F9FAFB;
    border-radius:8px;
    margin-bottom:8px;
  }

  .assigned-item .dev-info-row{
    display:flex;
    align-items:center;
    gap:12px;
  }

  .dev-avatar{
    width:30px;
    height:30px;
    min-width:30px;
    border-radius:50%;
    border:2px solid black;
    display:flex;
    align-items:center;
    justify-content:center;
  }

  .dev-name{
    font-size:13px;
    font-weight:600;
    color:#101828;
  }

  .dev-role{
    font-size:11px;
    color:#98A2B3;
  }

  .field-error{
    display:block;
    color:#D92D20;
    font-size:12px;
    padding:8px 24px 0;
}

  .btn-remove{
    border:1px solid #F04438;
    color:#F04438;
    background:white;
    padding:5px 14px;
    border-radius:5px;
    font-size:12px;
    font-weight:600;
    cursor:pointer;
  }

  .btn-remove:hover{
    background:#FEF3F2;
  }

  hr.divider{
    border:none;
    border-top:1px solid #E4E7EC;
    margin:18px 24px;
  }

  .add-developers-label{
    padding:0 24px;
    font-size:14px;
    font-weight:700;
    margin-bottom:12px;
  }

  .search-field{
    position:relative;
    margin:0 24px 12px;
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
    max-height:170px;
    overflow-y:auto;
    margin:0 4px 0 24px;
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
    justify-content:space-between;
    padding:8px 12px;
    border-radius:8px;
  }

  .dev-item:hover{
    background:#F9FAFB;
  }

  .btn-add{
    border:none;
    background:#DCEBFF;
    color:#2B6FFF;
    padding:6px 16px;
    border-radius:5px;
    font-size:12px;
    font-weight:600;
    cursor:pointer;
  }

  .btn-add:hover{
    background:#c7ddff;
  }

  .dev-footer{
    display:flex;
    justify-content:flex-end;
    gap:16px;
    padding:16px 24px 20px;
  }

  .link-cancel{
    font-size:14px;
    font-weight:600;
    color:#019BEF;
    background:none;
    border:none;
    cursor:pointer;
    text-decoration:none;
  }

  .btn-save{
    background:#019BEF;
    color:white;
    border:none;
    padding:9px 22px;
    border-radius:5px;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
  }

  .btn-save:hover{
    background:#1f5ae0;
  }

  /* ---------- Project deletion ---------- */

  .danger-card{
    border:1px solid #F04438;
    border-radius:14px;
    background:white;
    padding:0;
    overflow:hidden;
  }

  .danger-card h2{
    font-size:16px;
    font-weight:700;
    color:#D92D20;
    margin:0 0 12px;
  }

  .danger-body{
    padding:12px 12px 8px;
  }

  .danger-body p{
    font-size:13px;
    color:#475467;
    line-height:1.6;
    margin:0 0 10px;
  }

  .danger-body p strong{
    color:#101828;
  }

   .danger-header{
    background:#FFCDCD;
    padding:16px 14px;
  }

  .danger-header h2{
    font-size:16px;
    font-weight:700;
    color:red;
    margin:0;
  }

  .danger-actions{
    display:flex;
    justify-content:flex-end;
    margin-top:18px;
  }

  .btn-delete{
    border:1px solid #F04438;
    color:#D92D20;
    background:white;
    padding:8px 18px;
    border-radius:5px;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
  }

  .btn-delete:hover{
    background:#FEE4E2;
  }

.milestone-card{
    margin-top:24px;
    border:1px solid #101828;
    border-radius:10px;
    overflow:hidden;
    background:#FFFFFF;
    min-height:300px;

    display:flex;
    flex-direction:column;
}

.milestone-header{
    padding:14px 20px;
    background:#D0D0D0;
    border-bottom:1px solid #101828;

    font-size:16px;
    font-weight:600;
    color:#101828;
}

.milestone-list{
    flex:1;
    max-height:320px;
    min-height:220px;

    padding:16px 20px;

    overflow-y:auto;

    display:flex;
    flex-direction:column;
    gap:16px;
}

.milestone-item{
    padding-bottom:14px;
    border-bottom:1px solid #EAECF0;
}

.milestone-item:last-child{
    border-bottom:none;
}

.milestone-row{
    display:flex;
    align-items:flex-start;
    gap:14px;
}

.milestone-indicator{
    width:7px;
    height:7px;

    margin-top:5px;

    border-radius:999px;
    background:#32D74B;

    flex-shrink:0;
}

.milestone-content{
    flex:1;
}

.milestone-comment-header{
    display:flex;
    justify-content:space-between;
    align-items:center;

    margin-bottom:8px;
}

.milestone-user{
    font-size:12px;
    font-weight:600;
    color:#101828;
}

.milestone-date{
    margin-left:12px;

    font-size:9px;
    color:#98A2B3;
}

.milestone-description{
    font-size:11px;
    color:#475467;
    line-height:1.5;
}

.milestone-delete-btn{
    width:22px;
    height:22px;

    border:none;
    border-radius:5px;

    background:transparent;
    color:#D92D20;

    font-size:16px;
    line-height:1;

    cursor:pointer;
}

.milestone-delete-btn:hover{
    background:#FEE4E2;
}

.milestone-empty{
    font-size:11px;
    color:#98A2B3;
    padding:12px 0;
}

.milestone-comment-form{
    padding:12px 20px;
    border-top:1px solid #D0D5DD;
    background:#FFFFFF;
}

.milestone-comment-form textarea{
    width:100%;
    height:34px;
    min-height:34px;

    resize:none;

    border:1px solid #D0D5DD;
    border-radius:6px;

    padding:8px 10px;

    box-sizing:border-box;

    font-family:'Inter', sans-serif;
    font-size:11px;

    outline:none;
}

.milestone-comment-form textarea:focus{
    border-color:#2B6FFF;
}

.milestone-list::-webkit-scrollbar{
    width:8px;
}

.milestone-list::-webkit-scrollbar-track{
    background:#F2F4F7;
}

.milestone-list::-webkit-scrollbar-thumb{
    background:#98A2B3;
    border-radius:8px;
}

  </style>

</head>

<body>

    @include('admin.partials.admin-topbar')
    @include('admin.partials.admin-nav')

    <div class="page">

  <div class="breadcrumb">Projects &gt; <span class="current">PRJ-{{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}</span></div>
  <h1 class="page-title">Update Project</h1>
  <p class="page-subtitle">{{ $project->name }} — last updated {{ $project->updated_at->format('d F Y \a\t g:i A') }}</p>

  <form action="{{  route('admin.projects.update', $project) }}" method="POST">
    @csrf
    @method('PUT')

  <div class="card info-card">
    <div class="card-header">
      <h2>Project Information</h2>
    </div>

    <div class="card-body">

      <div class="form-field">
        <label for="project_id">Project ID</label>
        <input id="project_id" type="text" value="PRJ-{{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}" disabled>
      </div>

      <div class="field-row">
        <div class="form-field">
          <label for="project_name">Project Name</label>
          <input id="project_name" name="name" type="text" value="{{  old('name', $project->name) }}">
        </div>

        <div class="form-field">
          <label for="status">Status</label>
          <select id="status" name="status" required>

            @foreach (['Not Started', 'Ongoing', 'On Hold', 'Cancelled', 'Completed'] as $status)

            <option value="{{ $status }}" {{  old('status', $project->status) === $status ? 'selected' : '' }}>{{ $status }}</option>

            @endforeach

          </select>
        </div>
      </div>

      <div class="field-row">
        <div class="form-field">
          <label for="start_date">Start Date</label>
          <div class="date-input-wrap">
            <input id="start_date" name="start_date" type="date" value="{{  old('start_date', $project->start_date?->format('Y-m-d')) }}" required>
          </div>
        </div>

        <div class="form-field">
          <label for="end_date">End Date</label>
          <div class="date-input-wrap">
            <input id="end_date" name="end_date" type="date" value="{{  old('end_date', $project->end_date?->format('Y-m-d')) }}" required>
          </div>
        </div>
      </div>

      <div class="form-field" style="margin-bottom:0;">
        <label for="description">Project Description</label>
        <textarea id="description" name="description">{{  old('description', $project->description) }}</textarea>
      </div>
    </div>
  </div>

  <div class="bottom-row">

    <div class="card">
      <div class="card-header">
        <h2>Developer Assignment</h2>
        <span class="meta" id="assigned-count">{{ $project->assignedUsers->count() }} currently assigned</span>
      </div>

      <div class="assigned-list" id="assigned-list">

        @foreach ($project->assignedUsers as $developer)

          <div class="assigned-item" data-developer-id="{{ $developer->id }}" data-developer-name="{{ $developer->fullname }}">
            <div class="dev-info-row">
              <span class="dev-avatar">{{strtoupper(substr($developer->fullname, 0, 1)) }}</span>
              <div>
                <div class="dev-name">{{ $developer->fullname }}</div>
              </div>
            </div>

            @error('developers')
              <span class="field-error"> {{$message}}</span>
            @enderror

            <button class="btn-remove" type="button">&times; Remove</button>
            <input type="hidden" name="developers[]" value="{{ $developer->id }}" class="assigned-developer-input">
          </div>

        @endforeach
        
      </div>

      <hr class="divider">

      <div class="add-developers-label">Add Developers</div>

      <div class="search-field">
        <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27a6.47 6.47 0 0 0 1.57-4.23 6.5 6.5 0 1 0-6.5 6.5c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5Zm-6 0A4.5 4.5 0 1 1 14 9.5 4.5 4.5 0 0 1 9.5 14Z"/></svg>
        <input id="developer-search" type="text" placeholder="Search developers by name">
      </div>

      <div class="dev-list" id="developer-list">

        @foreach ($developers as $developer)

          @if (! $project->assignedUsers->contains('id', $developer->id))

          <div class="dev-item" data-developer-id="{{ $developer->id }}" data-developer-name="{{ $developer->fullname }}">
            <div class="dev-info-row">
              <span class="dev-avatar">{{ strtoupper(substr($developer->fullname, 0, 1)) }}</span>
              <div>
                <div class="dev-name">{{ $developer->fullname }}</div>
              </div>
            </div>
            <button class="btn-add" type="button">+ Add</button>
          </div>

          @endif

        @endforeach

      </div>

      <div class="dev-footer">
        <a href="{{  route('admin.projects.index') }}" class="link-cancel">Cancel</a>
        <button class="btn-save" type="submit">Save changes</button>
      </div>

    </div>
  </form>
    <div class="danger-card">
      <div class="danger-header">
        <h2>Project Deletion</h2>
      </div>
      <div class="danger-body">

        <p>Deleting <strong>{{ $project->name}}</strong> removes it permanently, along with its developer assignments.</p>
        <p>This cannot be undone.</p>

        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" id="delete-project-form">
            @csrf
            @method('DELETE')

            <div class="danger-actions">
            <button class="btn-delete" type="button" id="delete-project-btn">&#128465; Delete Project</button>
          </div>
        </form>

          </div>
</div>

</div>

<!-- ---------- Milestones ---------- -->

<div class="milestone-card">

    <div class="milestone-header">
        Milestones
    </div>

    <div
        class="milestone-list"
        id="milestone-list"
    >

        @forelse ($project->milestones as $milestone)

            <div
                class="milestone-item"
                data-milestone-id="{{ $milestone->id }}"
            >

                <div class="milestone-row">

                    <div class="milestone-indicator"></div>

                    <div class="milestone-content">

                        <div class="milestone-comment-header">

                            <div>
                                <strong class="milestone-user">
                                    {{ $milestone->user?->fullname ?? 'Unknown User' }}
                                </strong>

                                <span class="milestone-date">
                                    {{ $milestone->created_at->format('h:i A') }}
                                </span>
                            </div>

                            <button
                                type="button"
                                class="milestone-delete-btn"
                                data-milestone-id="{{ $milestone->id }}"
                                title="Delete milestone"
                            >
                                &times;
                            </button>

                        </div>

                        <div class="milestone-description">
                            {{ $milestone->description }}
                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div
                class="milestone-empty"
                id="milestone-empty"
            >
                No milestone updates yet.
            </div>

        @endforelse

    </div>

    <form
        id="milestone-form"
        class="milestone-comment-form"
        method="POST"
    >
        @csrf

        <textarea
            name="description"
            id="milestone-description"
            placeholder="Enter progress..."
            required
        ></textarea>
    </form>

</div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () 
{
    const assignedList = document.getElementById('assigned-list');
    const developerList = document.getElementById('developer-list');
    const assignedCount = document.getElementById('assigned-count');
    const searchInput = document.getElementById('developer-search');

    function updateAssignedCount() 
    {
        const count = assignedList.querySelectorAll('.assigned-item').length;

        assignedCount.textContent = count +' currently assigned';
    }

    function createAssignedItem(id, name) 
    {

        const item = document.createElement('div');

        item.classList.add('assigned-item');

        item.dataset.developerId = id;
        item.dataset.developerName = name;

        item.innerHTML = `
            <div class="dev-info-row">

                <span class="dev-avatar">${name.charAt(0).toUpperCase()}</span>

                <div>
                    <div class="dev-name">
                        ${name}
                    </div>
                </div>
            </div>

            <button class="btn-remove" type="button">&times; Remove</button>

            <input type="hidden" name="developers[]" value="${id}" class="assigned-developer-input">`;
        return item;
    }

    function createAvailableItem(id, name) 
    {

        const item = document.createElement('div');

        item.classList.add('dev-item');

        item.dataset.developerId = id;
        item.dataset.developerName = name;

        item.innerHTML = `
            <div class="dev-info-row">

                <span class="dev-avatar">${name.charAt(0).toUpperCase()}</span>
                <div>
                    <div class="dev-name">
                        ${name}
                    </div>
                </div>
            </div>

            <button class="btn-add" type="button">+ Add</button>`;
        return item;
    }

    developerList.addEventListener('click', function (event) 
    {

        const button = event.target.closest('.btn-add');

        if (!button) 
        {
            return;
        }

        const developerItem = button.closest('.dev-item');

        const id = developerItem.dataset.developerId;
        const name = developerItem.dataset.developerName;

        const assignedItem = createAssignedItem(id, name);

        assignedList.appendChild(assignedItem);

        developerItem.remove();

        updateAssignedCount();
    });

    assignedList.addEventListener('click', function (event) 
    {

        const button = event.target.closest('.btn-remove');

        if (!button) 
        {
            return;
        }

        const assignedItem = button.closest('.assigned-item');

        const id = assignedItem.dataset.developerId;
        const name = assignedItem.dataset.developerName;

        const availableItem = createAvailableItem(id, name);

        developerList.appendChild(availableItem);

        assignedItem.remove();

        updateAssignedCount();

    });

    searchInput.addEventListener('input', function () 
    {

        const searchValue = searchInput.value.toLowerCase().trim();

        developerList.querySelectorAll('.dev-item').forEach(function (item) {
          
          const name = item.dataset.developerName.toLowerCase();

                item.style.display = name.includes(searchValue)
                        ? 'flex'
                        : 'none';
            });
    });

    updateAssignedCount();

    const deleteButton = document.getElementById('delete-project-btn');
    const deleteForm = document.getElementById('delete-project-form');

      deleteButton.addEventListener('click', function()
    {
      const confirmed = confirm('Are you sure you want to delete this project? This action cannot be undo.');

      if (confirmed)
    {
      deleteForm.submit();
    }

    });

    // ---------------- MILESTONES ----------------

    const milestoneForm =
        document.getElementById(
            'milestone-form'
        );

    const milestoneDescription =
        document.getElementById(
            'milestone-description'
        );

    const milestoneList =
        document.getElementById(
            'milestone-list'
        );

    const milestoneStoreUrl =
        @json(
            route(
                'admin.projects.milestones.store',
                $project->id
            )
        );

    const milestoneDeleteUrl = @json(
    route(
        'admin.projects.milestones.destroy',
        [
            'project' => $project->id,
            'milestone' => '__MILESTONE__'
        ]
    )
);


    function createMilestoneItem(
        milestone
    ) {

        const item =
            document.createElement('div');

        item.classList.add(
            'milestone-item'
        );

        item.dataset.milestoneId =
            milestone.id;


        const row =
            document.createElement('div');

        row.classList.add(
            'milestone-row'
        );


        const indicator =
            document.createElement('div');

        indicator.classList.add(
            'milestone-indicator'
        );


        const content =
            document.createElement('div');

        content.classList.add(
            'milestone-content'
        );


        const header =
            document.createElement('div');

        header.classList.add(
            'milestone-comment-header'
        );


        const userInformation =
            document.createElement('div');


        const user =
            document.createElement('strong');

        user.classList.add(
            'milestone-user'
        );

        user.textContent =
            milestone.user;


        const date =
            document.createElement('span');

        date.classList.add(
            'milestone-date'
        );

        date.textContent =
            milestone.created_at;


        userInformation.appendChild(
            user
        );

        userInformation.appendChild(
            date
        );


        const deleteButton =
            document.createElement(
                'button'
            );

        deleteButton.type = 'button';

        deleteButton.classList.add(
            'milestone-delete-btn'
        );

        deleteButton.dataset.milestoneId =
            milestone.id;

        deleteButton.title =
            'Delete milestone';

        deleteButton.textContent =
            '×';


        const description =
            document.createElement('div');

        description.classList.add(
            'milestone-description'
        );

        description.textContent =
            milestone.description;


        header.appendChild(
            userInformation
        );

        header.appendChild(
            deleteButton
        );

        content.appendChild(
            header
        );

        content.appendChild(
            description
        );

        row.appendChild(
            indicator
        );

        row.appendChild(
            content
        );

        item.appendChild(
            row
        );

        return item;
    }


    // Press Enter to post
    milestoneDescription.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Enter' &&
                !event.shiftKey
            ) {

                event.preventDefault();

                if (
                    milestoneDescription
                        .value
                        .trim() === ''
                ) {
                    return;
                }

                milestoneForm.requestSubmit();
            }

        }
    );


    // Add milestone
    milestoneForm.addEventListener(
        'submit',
        async function (event) {

            event.preventDefault();

            const description =
                milestoneDescription
                    .value
                    .trim();

            if (description === '') {
                return;
            }

            const formData =
                new FormData(
                    milestoneForm
                );

            try {

                const response =
                    await fetch(
                        milestoneStoreUrl,
                        {
                            method: 'POST',

                            headers: {
                                'Accept':
                                    'application/json',
                            },

                            body: formData,
                        }
                    );

                if (!response.ok) {
                    throw new Error(
                        'Unable to add milestone.'
                    );
                }

                const data =
                    await response.json();

                const emptyMessage =
                    milestoneList.querySelector(
                        '.milestone-empty'
                    );

                if (emptyMessage) {
                    emptyMessage.remove();
                }

                const newItem =
                    createMilestoneItem(
                        data.milestone
                    );

                milestoneList.appendChild(
                    newItem
                );

                milestoneDescription.value =
                    '';

                milestoneDescription.focus();

                milestoneList.scrollTop =
                    milestoneList.scrollHeight;

            } catch (error) {

                console.error(error);

                alert(
                    'Unable to add milestone comment.'
                );

            }

        }
    );


    // Delete milestone
    milestoneList.addEventListener(
        'click',
        async function (event) {

            const deleteButton =
                event.target.closest(
                    '.milestone-delete-btn'
                );

            if (!deleteButton) {
                return;
            }

            const confirmed =
                confirm(
                    'Are you sure you want to delete this milestone comment?'
                );

            if (!confirmed) {
                return;
            }

            const milestoneId =
                deleteButton.dataset
                    .milestoneId;

            const deleteUrl =
                milestoneDeleteUrl.replace(
                    '__MILESTONE__',
                    milestoneId
                );

            try {

                const response =
                    await fetch(
                        deleteUrl,
                        {
                            method: 'DELETE',

                            headers: {
                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    document.querySelector(
                                        'meta[name="csrf-token"]'
                                    ).content,
                            },
                        }
                    );

                if (!response.ok) {
                    throw new Error(
                        'Unable to delete milestone.'
                    );
                }

                const milestoneItem =
                    deleteButton.closest(
                        '.milestone-item'
                    );

                milestoneItem.remove();


                if (
                    milestoneList
                        .querySelectorAll(
                            '.milestone-item'
                        )
                        .length === 0
                ) {

                    const empty =
                        document.createElement(
                            'div'
                        );

                    empty.classList.add(
                        'milestone-empty'
                    );

                    empty.textContent =
                        'No milestone updates yet.';

                    milestoneList.appendChild(
                        empty
                    );
                }

            } catch (error) {

                console.error(error);

                alert(
                    'Unable to delete milestone comment.'
                );

            }

        }
    );

});

</script>

</body>
</html