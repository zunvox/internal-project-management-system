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
        .page {
            max-width: 1100px;
            margin: 0 auto;
            padding: 20px 24px 64px;
        }

        .breadcrumb {
            font-size: 13px;
            color: #98A2B3;
            margin-bottom: 6px;
        }

        .breadcrumb .current {
            color: #101828;
            font-weight: 700;
        }

        .page-title {
            font-size: 28px;
            font-weight: 800;
            margin: 0 0 2px;
        }

        .page-subtitle {
            font-size: 13px;
            color: #98A2B3;
            margin: 0 0 18px;
        }

        .card {
            background: white;
            border: 1px solid #2B6FFF;
            border-radius: 14px;
            box-shadow: 0 20px 50px rgba(43, 111, 255, 0.18);
        }

        .card-header {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            padding: 18px 24px;
        }

        .card-header h2 {
            font-size: 16px;
            font-weight: 700;
            margin: 0;
        }

        .card-header .meta {
            font-size: 12px;
            color: #98A2B3;
        }

        /* ---------- Project information ---------- */

        .info-card {
            margin-bottom: 24px;
        }

        .card-body {
            padding: 0 24px 24px;
        }

        .form-field {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
        }

        .form-field label {
            font-size: 14px;
            font-weight: 700;
            color: #101828;
        }

        .form-field input,
        .form-field select,
        .form-field textarea {
            width: 100%;
            padding: 10px 14px;
            font-size: 13px;
            font-family: 'Inter', system-ui, sans-serif;
            color: black;
            background-color: #ffffff;
            border: 1px solid #D0D5DD;
            border-radius: 10px;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .form-field input:disabled {
            background-color: #D0D5DD;
            color: #475467;
        }

        .form-field textarea {
            resize: vertical;
            min-height: 60px;
            font-family: 'Inter', system-ui, sans-serif;
        }

        .form-field input:focus,
        .form-field select:focus,
        .form-field textarea:focus {
            border-color: #3538CD;
            box-shadow: 0 0 0 4px rgba(53, 56, 205, 0.14);
        }

        .field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .date-input-wrap {
            position: relative;
        }

        .date-input-wrap input {
            padding-right: 36px;
        }

        .date-input-wrap svg {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            fill: #667085;
            pointer-events: none;
        }

        /* ---------- Bottom row ---------- */

        .bottom-row {
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: 24px;
            align-items: start;
        }

        /* ---------- Developer assignment ---------- */

        .assigned-list {
            padding: 0 24px;
        }

        .assigned-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 12px;
            background: #F9FAFB;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .assigned-item .dev-info-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .dev-avatar {
            width: 30px;
            height: 30px;
            min-width: 30px;
            border-radius: 50%;
            border: 2px solid black;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .dev-name {
            font-size: 13px;
            font-weight: 600;
            color: #101828;
        }

        .dev-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .dev-role {
            font-size: 11px;
            color: #98A2B3;
        }

        .field-error {
            display: block;
            color: #D92D20;
            font-size: 12px;
            padding: 8px 24px 0;
        }

        .btn-remove {
            border: 1px solid #F04438;
            color: #F04438;
            background: white;
            padding: 5px 14px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-remove:hover {
            background: #FEF3F2;
        }

        hr.divider {
            border: none;
            border-top: 1px solid #E4E7EC;
            margin: 18px 24px;
        }

        .add-developers-label {
            padding: 0 24px;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .search-field {
            position: relative;
            margin: 0 24px 12px;
        }

        .search-field svg {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 15px;
            height: 15px;
            fill: #98A2B3;
        }

        .search-field input {
            width: 100%;
            padding: 9px 12px 9px 34px;
            font-size: 13px;
            font-family: 'Inter', system-ui, sans-serif;
            border: 1px solid #D0D5DD;
            border-radius: 10px;
            outline: none;
            background: #F9FAFB;
        }

        .search-field input::placeholder {
            color: #98A2B3;
        }

        .search-field input:focus {
            border-color: #3538CD;
            box-shadow: 0 0 0 4px rgba(53, 56, 205, 0.14);
            background: white;
        }

        .dev-list {
            max-height: 170px;
            overflow-y: auto;
            margin: 0 4px 0 24px;
            padding-right: 10px;
        }

        .dev-list::-webkit-scrollbar {
            width: 8px;
        }

        .dev-list::-webkit-scrollbar-track {
            background: #F2F4F7;
            border-radius: 8px;
        }

        .dev-list::-webkit-scrollbar-thumb {
            background: #98A2B3;
            border-radius: 8px;
        }

        .dev-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            border-radius: 8px;
        }

        .dev-item:hover {
            background: #F9FAFB;
        }

        .btn-add {
            border: none;
            background: #DCEBFF;
            color: #2B6FFF;
            padding: 6px 16px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-add:hover {
            background: #c7ddff;
        }

        .dev-footer {
            display: flex;
            justify-content: flex-end;
            gap: 16px;
            padding: 16px 24px 20px;
        }

        .link-cancel {
            font-size: 14px;
            font-weight: 600;
            color: #019BEF;
            background: none;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-save {
            background: #019BEF;
            color: white;
            border: none;
            padding: 9px 22px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-save:hover {
            background: #1f5ae0;
        }

        /* ---------- Project deletion ---------- */

        .danger-card {
            border: 1px solid #F04438;
            border-radius: 14px;
            background: white;
            padding: 0;
            overflow: hidden;
        }

        .danger-card h2 {
            font-size: 16px;
            font-weight: 700;
            color: #D92D20;
            margin: 0 0 12px;
        }

        .danger-body {
            padding: 12px 12px 8px;
        }

        .danger-body p {
            font-size: 13px;
            color: #475467;
            line-height: 1.6;
            margin: 0 0 10px;
        }

        .danger-body p strong {
            color: #101828;
        }

        .danger-header {
            background: #FFCDCD;
            padding: 16px 14px;
        }

        .danger-header h2 {
            font-size: 16px;
            font-weight: 700;
            color: red;
            margin: 0;
        }

        .danger-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 18px;
        }

        .btn-delete {
            border: 1px solid #F04438;
            color: #D92D20;
            background: white;
            padding: 8px 18px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-delete:hover {
            background: #FEE4E2;
        }

        .milestone-card {
            margin-top: 24px;
            border: 1px solid #101828;
            border-radius: 10px;
            overflow: hidden;
            background: #FFFFFF;
            min-height: 300px;
            display: flex;
            flex-direction: column;
        }

        .milestone-header {
            padding: 14px 20px;
            background: #D0D0D0;
            border-bottom: 1px solid #101828;
            font-size: 16px;
            font-weight: 600;
            color: #101828;
        }

        .milestone-list {
            flex: 1;
            max-height: 320px;
            min-height: 220px;
            padding: 16px 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .milestone-item {
            padding-bottom: 14px;
            border-bottom: 1px solid #EAECF0;
        }

        .milestone-item:last-child {
            border-bottom: none;
        }

        .milestone-row {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .milestone-indicator {
            width: 7px;
            height: 7px;
            margin-top: 5px;
            border-radius: 999px;
            background: #32D74B;
            flex-shrink: 0;
        }

        .milestone-content {
            flex: 1;
        }

        .milestone-comment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .milestone-user {
            font-size: 12px;
            font-weight: 600;
            color: #101828;
        }

        .milestone-date {
            margin-left: 12px;
            font-size: 9px;
            color: #98A2B3;
        }

        .milestone-description {
            font-size: 11px;
            color: #475467;
            line-height: 1.5;
        }

        .milestone-delete-btn {
            width: 22px;
            height: 22px;
            border: none;
            border-radius: 5px;
            background: transparent;
            color: #D92D20;
            font-size: 16px;
            line-height: 1;
            cursor: pointer;
        }

        .milestone-delete-btn:hover {
            background: #FEE4E2;
        }

        .milestone-empty {
            font-size: 11px;
            color: #98A2B3;
            padding: 12px 0;
        }

        .milestone-comment-form {
            padding: 12px 20px;
            border-top: 1px solid #D0D5DD;
            background: #FFFFFF;
        }

        .milestone-comment-form textarea {
            width: 100%;
            height: 34px;
            min-height: 34px;
            resize: none;
            border: 1px solid #D0D5DD;
            border-radius: 6px;
            padding: 8px 10px;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            outline: none;
        }

        .milestone-comment-form textarea:focus {
            border-color: #2B6FFF;
        }

        .milestone-list::-webkit-scrollbar {
            width: 8px;
        }

        .milestone-list::-webkit-scrollbar-track {
            background: #F2F4F7;
        }

        .milestone-list::-webkit-scrollbar-thumb {
            background: #98A2B3;
            border-radius: 8px;
        }

        .milestone-attachment-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
        }

        .milestone-attachment-button {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 10px;

            border: 1px solid #D0D5DD;
            border-radius: 6px;

            background: #FFFFFF;

            font-size: 10px;
            color: #344054;

            cursor: pointer;
        }

        .milestone-attachment-button:hover {
            background: #F2F4F7;
        }

        .milestone-attachment-name {
            max-width: 220px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;

            font-size: 10px;
            color: #667085;
        }

        .milestone-file {
            margin-top: 6px;
        }

        .milestone-file a {
            display: inline-flex;
            align-items: center;
            gap: 5px;

            font-size: 11px;
            color: #1677ff;
            text-decoration: none;
        }

        .milestone-file a:hover {
            text-decoration: underline;
        }

        .milestone-image {
            display: block;
            max-width: 260px;
            max-height: 180px;
            width: auto;
            height: auto;
            margin-top: 8px;
            border: 1px solid #D0D5DD;
            border-radius: 8px;
            object-fit: contain;
            cursor: pointer;
        }

        .milestone-file-name {
            margin-top: 5px;

            font-size: 10px;
            color: #667085;
        }
    </style>

</head>

<body>

    @include('admin.partials.admin-topbar')
    @include('admin.partials.admin-nav')

    <div class="stage">
    <div class="page">

        <div class="breadcrumb">Projects &gt; <span
                class="current">PRJ-{{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}</span></div>
        <h1 class="page-title">Update Project</h1>
        <p class="page-subtitle">{{ $project->name }} — last updated
            {{ $project->updated_at->format('d F Y \a\t g:i A') }}</p>

        <form action="{{ route('admin.projects.update', $project) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card info-card">
                <div class="card-header">
                    <h2>Project Information</h2>
                </div>

                <div class="card-body">

                    <div class="form-field">
                        <label for="project_id">Project ID</label>
                        <input id="project_id" type="text"
                            value="PRJ-{{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}" disabled>
                    </div>

                    <div class="field-row">
                        <div class="form-field">
                            <label for="project_name">Project Name</label>
                            <input id="project_name" name="name" type="text"
                                value="{{ old('name', $project->name) }}">
                        </div>

                        <div class="form-field">
                            <label for="status">Status</label>
                            <select id="status" name="status" required>

                                @foreach (['Not Started', 'Ongoing', 'On Hold', 'Cancelled', 'Completed'] as $status)
                                    <option value="{{ $status }}"
                                        {{ old('status', $project->status) === $status ? 'selected' : '' }}>
                                        {{ $status }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="field-row">
                        <div class="form-field">
                            <label for="start_date">Start Date</label>
                            <div class="date-input-wrap">
                                <input id="start_date" name="start_date" type="date"
                                    value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}" required>
                            </div>
                        </div>

                        <div class="form-field">
                            <label for="end_date">End Date</label>
                            <div class="date-input-wrap">
                                <input id="end_date" name="end_date" type="date"
                                    value="{{ old('end_date', $project->end_date?->format('Y-m-d')) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-field" style="margin-bottom:0;">
                        <label for="description">Project Description</label>
                        <textarea id="description" name="description">{{ old('description', $project->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="bottom-row">

                <div class="card">
                    <div class="card-header">
                        <h2>Developer Assignment</h2>
                        <span class="meta" id="assigned-count">{{ $project->assignedUsers->count() }} currently
                            assigned</span>
                    </div>

                    <div class="assigned-list" id="assigned-list">

                        @foreach ($project->assignedUsers as $developer)
                            <div class="assigned-item" data-developer-id="{{ $developer->id }}"
                                data-developer-name="{{ $developer->fullname }}"
                                data-developer-photo="{{ $developer->profile_picture ? asset('storage/' . $developer->profile_picture) : '' }}">
                                <div class="dev-info-row">
                                    <span class="dev-avatar">

                                        @if ($developer->profile_picture)
                                            <img src="{{ asset('storage/' . $developer->profile_picture) }}"
                                                alt="{{ $developer->fullname }}">
                                        @else
                                            {{ strtoupper(substr($developer->fullname, 0, 1)) }}
                                        @endif

                                    </span>
                                    <div>
                                        <div class="dev-name">{{ $developer->fullname }}</div>
                                    </div>
                                </div>

                                @error('developers')
                                    <span class="field-error"> {{ $message }}</span>
                                @enderror

                                <button class="btn-remove" type="button">&times; Remove</button>
                                <input type="hidden" name="developers[]" value="{{ $developer->id }}"
                                    class="assigned-developer-input">
                            </div>
                        @endforeach

                    </div>

                    <hr class="divider">

                    <div class="add-developers-label">Add Developers</div>

                    <div class="search-field">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M15.5 14h-.79l-.28-.27a6.47 6.47 0 0 0 1.57-4.23 6.5 6.5 0 1 0-6.5 6.5c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5Zm-6 0A4.5 4.5 0 1 1 14 9.5 4.5 4.5 0 0 1 9.5 14Z" />
                        </svg>
                        <input id="developer-search" type="text" placeholder="Search developers by name">
                    </div>

                    <div class="dev-list" id="developer-list">

                        @foreach ($developers as $developer)
                            @if (!$project->assignedUsers->contains('id', $developer->id))
                                <div class="dev-item" data-developer-id="{{ $developer->id }}"
                                    data-developer-name="{{ $developer->fullname }}"
                                    data-developer-photo="{{ $developer->profile_picture ? asset('storage/' . $developer->profile_picture) : '' }}">
                                    <div class="dev-info-row">
                                        <span class="dev-avatar">

                                            @if ($developer->profile_picture)
                                                <img src="{{ asset('storage/' . $developer->profile_picture) }}"
                                                    alt="{{ $developer->fullname }}">
                                            @else
                                                {{ strtoupper(substr($developer->fullname, 0, 1)) }}
                                            @endif

                                        </span>
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
                        <a href="{{ route('admin.projects.index') }}" class="link-cancel">Cancel</a>
                        <button class="btn-save" type="submit">Save changes</button>
                    </div>

                </div>
        </form>
        <div class="danger-card">
            <div class="danger-header">
                <h2>Project Deletion</h2>
            </div>
            <div class="danger-body">

                <p>Deleting <strong>{{ $project->name }}</strong> removes it permanently, along with its developer
                    assignments.</p>
                <p>This cannot be undone.</p>

                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST"
                    id="delete-project-form">
                    @csrf
                    @method('DELETE')

                    <div class="danger-actions">
                        <button class="btn-delete" type="button" id="delete-project-btn">&#128465; Delete
                            Project</button>
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

        <div class="milestone-list" id="milestone-list">

            @forelse ($project->milestones as $milestone)
                <div class="milestone-item" data-milestone-id="{{ $milestone->id }}">

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

                                <button type="button" class="milestone-delete-btn"
                                    data-milestone-id="{{ $milestone->id }}" title="Delete milestone">
                                    &times;
                                </button>

                            </div>

                            @if ($milestone->description)
                                <div class="milestone-description">
                                    {{ $milestone->description }}
                                </div>
                            @endif

                            @if ($milestone->attachment_path)
                                @php
                                    $extension = strtolower(pathinfo($milestone->attachment_name, PATHINFO_EXTENSION));

                                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'webp']);
                                @endphp

                                <div class="milestone-file">

                                    @if ($isImage)
                                        <a href="{{ asset('storage/' . $milestone->attachment_path) }}"
                                            target="_blank" rel="noopener">
                                            <img src="{{ asset('storage/' . $milestone->attachment_path) }}"
                                                alt="{{ $milestone->attachment_name }}" class="milestone-image">
                                        </a>

                                        <div class="milestone-file-name">
                                            📎 {{ $milestone->attachment_name }}
                                        </div>
                                    @else
                                        <a href="{{ asset('storage/' . $milestone->attachment_path) }}"
                                            target="_blank" rel="noopener">
                                            📎 {{ $milestone->attachment_name }}
                                        </a>
                                    @endif

                                </div>
                            @endif

                        </div>

                    </div>

                </div>

            @empty

                <div class="milestone-empty" id="milestone-empty">
                    No milestone updates yet.
                </div>
            @endforelse

        </div>

        <form id="milestone-form" class="milestone-comment-form" method="POST"
            action="{{ route('admin.projects.milestones.store', $project) }}" enctype="multipart/form-data">
            @csrf

            <textarea name="description" id="milestone-description" placeholder="Enter progress..."></textarea>

            <div class="milestone-attachment-row">

                <label for="admin-milestone-attachment" class="milestone-attachment-button">
                    📎 Attach file
                </label>

                <input type="file" name="attachment" id="admin-milestone-attachment"
                    accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.zip" hidden>

                <span id="admin-milestone-attachment-name" class="milestone-attachment-name"></span>

                <button type="submit" class="milestone-post-button">
                    Post
                </button>

            </div>
        </form>

    </div>

    </div>
</div>

    <script>
        const assignedList = document.getElementById('assigned-list');
        const developerList = document.getElementById('developer-list');
        const assignedCount = document.getElementById('assigned-count');
        const searchInput = document.getElementById('developer-search');


        function updateAssignedCount() {
            const count =
                assignedList.querySelectorAll('.assigned-item').length;

            assignedCount.textContent =
                count + ' currently assigned';
        }


        function createAvatarHtml(name, photo) {
            if (photo) {
                return `
            <span class="dev-avatar">
                <img
                    src="${photo}"
                    alt="${name}"
                >
            </span>
        `;
            }

            return `
        <span class="dev-avatar">
            ${name.charAt(0).toUpperCase()}
        </span>
    `;
        }


        function createAssignedItem(id, name, photo) {
            const item = document.createElement('div');

            item.classList.add('assigned-item');

            item.dataset.developerId = id;
            item.dataset.developerName = name;
            item.dataset.developerPhoto = photo || '';

            const avatarHtml =
                createAvatarHtml(name, photo);

            item.innerHTML = `
        <div class="dev-info-row">

            ${avatarHtml}

            <div>
                <div class="dev-name">
                    ${name}
                </div>
            </div>

        </div>

        <button
            class="btn-remove"
            type="button"
        >
            &times; Remove
        </button>

        <input
            type="hidden"
            name="developers[]"
            value="${id}"
            class="assigned-developer-input"
        >
    `;

            return item;
        }


        function createAvailableItem(id, name, photo) {
            const item = document.createElement('div');

            item.classList.add('dev-item');

            item.dataset.developerId = id;
            item.dataset.developerName = name;
            item.dataset.developerPhoto = photo || '';

            const avatarHtml =
                createAvatarHtml(name, photo);

            item.innerHTML = `
        <div class="dev-info-row">

            ${avatarHtml}

            <div>
                <div class="dev-name">
                    ${name}
                </div>
            </div>

        </div>

        <button
            class="btn-add"
            type="button"
        >
            + Add
        </button>
    `;

            return item;
        }


        developerList.addEventListener('click', function(event) {
            const button =
                event.target.closest('.btn-add');

            if (!button) {
                return;
            }

            const developerItem =
                button.closest('.dev-item');

            const id =
                developerItem.dataset.developerId;

            const name =
                developerItem.dataset.developerName;

            const photo =
                developerItem.dataset.developerPhoto;

            const assignedItem =
                createAssignedItem(
                    id,
                    name,
                    photo
                );

            assignedList.appendChild(assignedItem);

            developerItem.remove();

            updateAssignedCount();
        });


        assignedList.addEventListener('click', function(event) {
            const button =
                event.target.closest('.btn-remove');

            if (!button) {
                return;
            }

            const assignedItem = button.closest('.assigned-item');

            const id = assignedItem.dataset.developerId;

            const name = assignedItem.dataset.developerName;

            const photo = assignedItem.dataset.developerPhoto;

            const availableItem = createAvailableItem(
                id,
                name,
                photo
            );

            developerList.appendChild(availableItem);

            assignedItem.remove();

            updateAssignedCount();
        });


        searchInput.addEventListener('input', function() {
            const searchValue =
                searchInput.value
                .toLowerCase()
                .trim();

            developerList
                .querySelectorAll('.dev-item')
                .forEach(function(item) {
                    const name =
                        item.dataset.developerName
                        .toLowerCase();

                    item.style.display =
                        name.includes(searchValue) ?
                        'flex' :
                        'none';
                });
        });

        /*Milestone*/

        const milestoneForm =
            document.getElementById('milestone-form');

        const milestoneDescription =
            document.getElementById('milestone-description');

        const milestoneAttachment =
            document.getElementById('admin-milestone-attachment');

        const milestoneAttachmentName =
            document.getElementById(
                'admin-milestone-attachment-name'
            );

        const milestoneList =
            document.getElementById('milestone-list');


        /*Show selected attachment name*/

        milestoneAttachment.addEventListener(
            'change',
            function() {
                if (this.files.length > 0) {
                    milestoneAttachmentName.textContent =
                        this.files[0].name;
                } else {
                    milestoneAttachmentName.textContent = '';
                }
            }
        );


        /*Submit milestone*/

        async function submitMilestone() {
            const description =
                milestoneDescription.value.trim();

            const hasAttachment =
                milestoneAttachment.files.length > 0;

            if (
                description === '' &&
                !hasAttachment
            ) {
                return;
            }

            const formData =
                new FormData(milestoneForm);

            if (!formData.has('_token')) {
                formData.append(
                    '_token',
                    document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content
                );
            }

            try {
                const response = await fetch(
                    milestoneForm.action, {
                        method: 'POST',

                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },

                        credentials: 'same-origin',

                        body: formData,
                    }
                );

                const data = await response.json();

                if (!response.ok) {
                    alert(
                        data.message ??
                        'Unable to add milestone.'
                    );

                    return;
                }

                addMilestoneToList(
                    data.milestone
                );

                milestoneDescription.value = '';
                milestoneAttachment.value = '';
                milestoneAttachmentName.textContent = '';

                milestoneDescription.focus();

            } catch (error) {
                console.error(error);

                alert(
                    'Unable to add milestone.'
                );
            }
        }


        /*Enter to post*/

        milestoneDescription.addEventListener(
            'keydown',
            function(event) {

                if (
                    event.key === 'Enter' &&
                    !event.shiftKey
                ) {
                    event.preventDefault();

                    submitMilestone();
                }
            }
        );


        /*Prevent normal form submission*/

        milestoneForm.addEventListener(
            'submit',
            function(event) {
                event.preventDefault();

                submitMilestone();
            }
        );


        /*Add milestone to page without refresh*/

        function addMilestoneToList(milestone) {

            const emptyMessage =
                document.getElementById(
                    'milestone-empty'
                );

            if (emptyMessage) {
                emptyMessage.remove();
            }

            const item =
                document.createElement('div');

            item.className =
                'milestone-item';

            item.dataset.milestoneId =
                milestone.id;

            const descriptionHtml =
                milestone.description ?
                `
                <div class="milestone-description">
                    ${escapeHtml(
                        milestone.description
                    )}
                </div>
            ` :
                '';

            let attachmentHtml = '';

            if (
                milestone.attachment_url &&
                milestone.attachment_name
            ) {
                const extension =
                    milestone.attachment_name
                    .split('.')
                    .pop()
                    .toLowerCase();

                const imageExtensions = [
                    'jpg',
                    'jpeg',
                    'png',
                    'webp'
                ];

                const isImage =
                    imageExtensions.includes(extension);

                if (isImage) {
                    attachmentHtml = `
            <div class="milestone-file">

                <a
                    href="${milestone.attachment_url}"
                    target="_blank"
                    rel="noopener"
                >
                    <img
                        src="${milestone.attachment_url}"
                        alt="${escapeHtml(
                            milestone.attachment_name
                        )}"
                        class="milestone-image"
                    >
                </a>

                <div class="milestone-file-name">
                    📎 ${escapeHtml(
                        milestone.attachment_name
                    )}
                </div>

            </div>
        `;
                } else {
                    attachmentHtml = `
            <div class="milestone-file">

                <a
                    href="${milestone.attachment_url}"
                    target="_blank"
                    rel="noopener"
                >
                    📎 ${escapeHtml(
                        milestone.attachment_name
                    )}
                </a>

            </div>
        `;
                }
            }

            item.innerHTML = `
        <div class="milestone-row">

            <div class="milestone-indicator"></div>

            <div class="milestone-content">

                <div class="milestone-comment-header">

                    <div>
                        <strong class="milestone-user">
                            ${escapeHtml(
                                milestone.user
                            )}
                        </strong>

                        <span class="milestone-date">
                            ${escapeHtml(
                                milestone.created_at
                            )}
                        </span>
                    </div>

                    <button
                        type="button"
                        class="milestone-delete-btn"
                        data-milestone-id="${milestone.id}"
                        title="Delete milestone"
                    >
                        &times;
                    </button>

                </div>

                ${descriptionHtml}
                ${attachmentHtml}

            </div>
        </div>
    `;

            milestoneList.appendChild(item);

            milestoneList.scrollTop =
                milestoneList.scrollHeight;
        }


        /*Escape output inserted into HTML*/

        function escapeHtml(value) {
            const div =
                document.createElement('div');

            div.textContent =
                value ?? '';

            return div.innerHTML;
        }

        /*Delete milestone*/

        milestoneList.addEventListener(
            'click',
            async function(event) {

                const deleteButton =
                    event.target.closest(
                        '.milestone-delete-btn'
                    );

                if (!deleteButton) {
                    return;
                }

                const milestoneId =
                    deleteButton.dataset.milestoneId;

                const confirmed = confirm(
                    'Are you sure you want to delete this milestone?'
                );

                if (!confirmed) {
                    return;
                }

                const deleteUrl =
                    `{{ url('/admin/projects/' . $project->id . '/milestones') }}/${milestoneId}`;

                try {
                    const response = await fetch(
                        deleteUrl, {
                            method: 'DELETE',

                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]'
                                ).content,
                            },

                            credentials: 'same-origin',
                        }
                    );

                    const data =
                        await response.json();

                    if (!response.ok) {
                        alert(
                            data.message ??
                            'Unable to delete milestone.'
                        );

                        return;
                    }

                    const milestoneItem =
                        milestoneList.querySelector(
                            `[data-milestone-id="${milestoneId}"]`
                        );

                    if (milestoneItem) {
                        milestoneItem.remove();
                    }

                    /*Show empty message if no milestones remain*/

                    const remainingMilestones =
                        milestoneList.querySelectorAll(
                            '.milestone-item'
                        );

                    if (
                        remainingMilestones.length === 0
                    ) {
                        const emptyMessage =
                            document.createElement('div');

                        emptyMessage.className =
                            'milestone-empty';

                        emptyMessage.id =
                            'milestone-empty';

                        emptyMessage.textContent =
                            'No milestone updates yet.';

                        milestoneList.appendChild(
                            emptyMessage
                        );
                    }

                } catch (error) {
                    console.error(error);

                    alert(
                        'Unable to delete milestone.'
                    );
                }
            }
        );

        updateAssignedCount();
    </script>

</body>

</html
