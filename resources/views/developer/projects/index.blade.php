<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Project Index</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <style>
        .page {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 18px 38px 0;
            box-sizing: border-box;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            padding-bottom: 14px;
            border-bottom: 1px solid #D0D5DD;
        }

        .page-title {
            font-size: 32px;
            font-weight: 800;
            margin: 0;
            color: #101828;
        }

        /* ---------- Search ---------- */

        .search-field {
            position: relative;
            max-width: 185px;
            margin-bottom: 16px;
        }

        .search-field svg {
            position: absolute;
            left: 7px;
            top: 50%;
            transform: translateY(-50%);
            width: 11px;
            height: 11px;
            fill: #98A2B3;
        }

        .search-field input {
            width: 100%;
            height: 20px;
            padding: 2px 8px 2px 22px;
            font-size: 10px;
            font-family: 'Inter', system-ui, sans-serif;
            border: 1px solid #BFC4CC;
            border-radius: 7px;
            outline: none;
            background: white;
        }

        .search-field input::placeholder {
            color: #98A2B3;
        }

        .search-field input:focus {
            border-color: #3538CD;
            box-shadow: 0 0 0 4px rgba(53, 56, 205, 0.14);
        }

        .no-search-results {
            font-size: 11px;
            color: #98A2B3;
            text-align: center;
            padding: 16px 8px;
        }

        /* ---------- Board ---------- */

        .board {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
            align-items: start;
        }

        .column-header {
            display: flex;
            align-items: center;
            gap: 6px;
            padding-bottom: 7px;
            border-bottom: 1px solid #D0D5DD;
            margin-bottom: 10px;
        }

        .column-header h2 {
            font-size: 14px;
            font-weight: 700;
            margin: 0;
        }

        .status-dot {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            position: relative;
        }

        .dot-not-started {
            background: #E9C24C;
        }

        .dot-ongoing {
            background: #64D3EB;
        }

        .dot-completed {
            background: #5FE287;
        }

        .dot-on-hold {
            background: #FF8A8A;
        }

        .dot-cancelled {
            background: #C8C8C8;
        }

        .status-dot::after {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #333;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .column-header h2 {
            font-size: 15px;
            font-weight: 700;
            margin: 0;
        }

        .column-scroll {
            max-height: calc(100vh - 260px);
            overflow-y: auto;
            padding-right: 6px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .column-scroll::-webkit-scrollbar {
            width: 8px;
        }

        .column-scroll::-webkit-scrollbar-track {
            background: #EAF0FF;
            border-radius: 8px;
        }

        .column-scroll::-webkit-scrollbar-thumb {
            background: #98A2B3;
            border-radius: 8px;
        }

        /* ---------- Project card ---------- */

        .project-card {
            background: white;
            border: 1px solid #2B6FFF;
            border-radius: 12px;
            padding: 0;
            overflow: hidden;
            box-shadow: 0 5px 10px rgba(43, 111, 255, 0.28);
            transition: transform 0.15s ease;
            flex-shrink: 0;
        }

        .project-card.selected {
            background: #2B6FFF;
            border-color: #2B6FFF;
        }

        .project-card-header {
            background: #8FAFF2;
            padding: 8px 10px;
            text-align: center;
        }

        .project-card.selected .project-card-header {
            background: #2B6FFF;
        }

        .project-card-link {
            text-decoration: none;
            color: inherit;
            display: block;
            cursor: pointer;
        }

        .project-card-link:hover .project-card {
            transform: translateY(-2px);
        }

        .empty-projects {
            font-size: 11px;
            font-weight: 400;
            color: #98A2B3;
            padding: 8px 4px;
        }

        .project-card-body {
            padding: 6px 8px 14px;
        }

        .project-name {
            font-size: 12px;
            font-weight: 700;
            color: #101828;
            margin: 0;
        }

        .project-card.selected .project-name {
            color: white;
        }

        .project-id {
            font-size: 10px;
            font-weight: 700;
            color: #2B6FFF;
            margin-bottom: 4px;
        }

        .project-card.selected .project-id {
            color: #D1E9FF;
        }

        .project-desc {
            font-size: 10px;
            color: #98A2B3;
            line-height: 1.35;
            margin-bottom: 12px;
        }

        .project-card.selected .project-desc {
            color: #E4E7EC;
        }

        .project-meta {
            display: flex;
            flex-direction: column;
            gap: 2px;
            margin-bottom: 4px;
        }

        .meta-row {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 10px;
            color: #475467;
        }

        .project-card.selected .meta-row {
            color: #E4E7EC;
        }

        .meta-row svg {
            width: 12px;
            height: 12px;
            fill: #667085;
        }

        .project-card.selected .meta-row svg {
            fill: #E4E7EC;
        }

        .status-pill {
            display: inline-block;
            padding: 2px 12px;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 500;
        }

        .pill-not-started {
            background: #FEF0C7;
            color: #B54708;
        }

        .pill-ongoing {
            background: #D1E9FF;
            color: #175CD3;
        }

        .pill-completed {
            background: #D3F8DF;
            color: #1A7F37;
        }

        .pill-on-hold {
            background: #FEE4E2;
            color: #D92D20;
        }

        .pill-cancelled {
            background: #EAECF0;
            color: #667085;
        }

        #modal-project-status {
            padding: 3px 16px;
            font-size: 11px;
            min-width: 78px;
            text-align: center;
        }

        .project-card.selected .status-pill {
            background: rgba(255, 255, 255, 0.85);
        }

        .project-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .project-modal-overlay.active {
            display: flex;
        }

        .project-modal {
            position: relative;
            width: min(900px, 92vw);
            min-height: 480px;
            background: #FFFFFF;
            border: 2px solid #7AA7FF;
            border-radius: 14px;
            padding: 24px 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        }

        .project-modal-close {
            position: absolute;
            top: 14px;
            right: 18px;
            width: 30px;
            height: 30px;
            border: 1px solid #667085;
            border-radius: 7px;
            background: #FFFFFF;
            cursor: pointer;
        }

        .project-modal-header {
            display: flex;
            align-items: center;
            gap: 28px;
            padding-right: 50px;
            margin-bottom: 30px;
        }

        .project-modal-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }

        .project-modal-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
        }

        .project-modal-details {
            padding: 8px 4px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            column-gap: 36px;
        }

        .detail-left {
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        .assigned-developers {
            align-self: start;
        }

        .developer-avatars {
            display: flex;
            align-items: center;
            margin-top: 6px;
        }

        .developer-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #FFFFFF;
            border: 2px solid #101828;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: #101828;
            margin-left: -8px;
        }

        .developer-avatar:first-child {
            margin-left: 0;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .detail-label {
            font-size: 16px;
            color: #98A2B3;
        }

        .detail-item strong,
        .detail-description strong {
            font-size: 14px;
            color: #101828;
        }

        .detail-description {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-top: 32px;
            line-height: 1.4;
        }

        .milestone-panel {
            height: 380px;
            border: 1px solid #101828;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .milestone-title {
            padding: 12px 16px;
            background: #F2F4F7;
            border-bottom: 1px solid #101828;
            font-size: 18px;
            flex-shrink: 0;
        }

        .milestone-list {
            padding: 14px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            flex: 1;
            max-height: 260px;
            overflow-y: auto;
        }

        .milestone-item {
            padding-bottom: 12px;
            border-bottom: 1px solid #E4E7EC;
        }

        .milestone-item:last-child {
            border-bottom: none;
        }

        .milestone-comment-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
        }

        .milestone-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1px solid #101828;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .milestone-user {
            font-size: 11px;
            font-weight: 600;
            color: #101828;
        }

        .milestone-date {
            font-size: 9px;
            color: #98A2B3;
        }

        .milestone-description {
            font-size: 11px;
            color: #475467;
            line-height: 1.4;
            padding-left: 38px;
        }

        .milestone-empty {
            font-size: 11px;
            color: #98A2B3;
            padding: 10px 2px;
        }

        .milestone-delete-btn {
            margin-top: 6px;
            margin-left: 38px;
            padding: 2px 7px;
            border: 1px solid #D92D20;
            border-radius: 5px;
            background: #FFFFFF;
            color: #D92D20;
            font-size: 9px;
            cursor: pointer;
        }

        .milestone-delete-btn:hover {
            background: #FEE4E2;
        }

        .milestone-comment-form {
            border-top: 1px solid #E4E7EC;
            padding: 10px 12px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex-shrink: 0;
        }

        .milestone-comment-form textarea {
            width: 100%;
            min-height: 42px;
            max-height: 90px;
            resize: none;
            border: 1px solid #D0D5DD;
            border-radius: 7px;
            padding: 9px 10px;
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            box-sizing: border-box;
            outline: none;
        }

        .milestone-comment-form textarea:focus {
            border-color: #2B6FFF;
        }
    </style>

</head>

<body>

    @include('developer.partials.developer-topbar')
    @include('developer.partials.developer-nav')

    <div class="page">

        <div class="page-header">
            <h1 class="page-title">Project Index</h1>
        </div>

        <div class="search-field">
            <svg viewBox="0 0 24 24">
                <path
                    d="M15.5 14h-.79l-.28-.27a6.47 6.47 0 0 0 1.57-4.23 6.5 6.5 0 1 0-6.5 6.5c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5Zm-6 0A4.5 4.5 0 1 1 14 9.5 4.5 4.5 0 0 1 9.5 14Z" />
            </svg>
            <input type="text" id="project-search" placeholder="Search...">
        </div>

        <div class="board">

            <!-- Ongoing -->
            <div class="column">


                <div class="column-header">
                    <span class="status-dot dot-ongoing"></span>
                    <h2>Ongoing</h2>
                </div>

                <div class="column-scroll">

                    @forelse ($ongoingProjects as $project)
                        <div class="project-card-link" data-project-id="{{ $project->id }}"
                            data-search="{{ strtolower(
                                $project->name .
                                    ' ' .
                                    ($project->description ?? '') .
                                    ' ' .
                                    $project->status .
                                    ' ' .
                                    ($project->creator?->fullname ?? ''),
                            ) }}">

                            <div class="project-card">

                                <div class="project-card-header">
                                    <div class="project-name">
                                        {{ $project->name }}
                                    </div>
                                </div>

                                <div class="project-card-body">

                                    <div class="project-id">
                                        PRJ-{{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}
                                    </div>

                                    <div class="project-desc">
                                        {{ $project->description ?? 'No project description.' }}
                                    </div>

                                    <div class="project-meta">

                                        <div class="meta-row">
                                            <svg viewBox="0 0 24 24">
                                                <path
                                                    d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0 2c-4.4 0-8 2.2-8 5v2h16v-2c0-2.8-3.6-5-8-5Z" />
                                            </svg>

                                            {{ $project->creator?->fullname ?? 'Unknown Admin' }}
                                        </div>

                                        <div class="meta-row">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M14.4 6 14 4H5v17h2v-7h5.6l.4 2h7V6z" />
                                            </svg>

                                            {{ $project->end_date?->format('d F Y') }}
                                        </div>

                                    </div>

                                    <span class="status-pill pill-ongoing">Ongoing</span>
                                </div>
                            </div>
                        </div>

                    @empty

                        <div class="empty-projects">
                            No ongoing projects.
                        </div>
                    @endforelse

                    <div class="no-search-results" style="display:none;">No matching projects.</div>

                </div>

            </div>

            <!-- Completed -->
            <div class="column">

                <div class="column-header">
                    <span class="status-dot dot-completed"></span>
                    <h2>Completed</h2>
                </div>

                <div class="column-scroll">

                    @forelse ($completedProjects as $project)
                        <div class="project-card-link" data-project-id="{{ $project->id }}"
                            data-search="{{ strtolower(
                                $project->name .
                                    ' ' .
                                    ($project->description ?? '') .
                                    ' ' .
                                    $project->status .
                                    ' ' .
                                    ($project->creator?->fullname ?? ''),
                            ) }}">

                            <div class="project-card">

                                <div class="project-card-header">
                                    <div class="project-name">
                                        {{ $project->name }}
                                    </div>
                                </div>

                                <div class="project-card-body">

                                    <div class="project-id">
                                        PRJ-{{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}
                                    </div>

                                    <div class="project-desc">
                                        {{ $project->description ?? 'No project description.' }}
                                    </div>

                                    <div class="project-meta">

                                        <div class="meta-row">
                                            <svg viewBox="0 0 24 24">
                                                <path
                                                    d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0 2c-4.4 0-8 2.2-8 5v2h16v-2c0-2.8-3.6-5-8-5Z" />
                                            </svg>

                                            {{ $project->creator?->fullname ?? 'Unknown Admin' }}
                                        </div>

                                        <div class="meta-row">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M14.4 6 14 4H5v17h2v-7h5.6l.4 2h7V6z" />
                                            </svg>

                                            {{ $project->end_date?->format('d F Y') }}
                                        </div>

                                    </div>

                                    <span class="status-pill pill-completed">
                                        Completed
                                    </span>

                                </div>

                            </div>
                        </div>

                    @empty

                        <div class="empty-projects">
                            No completed projects.
                        </div>
                    @endforelse

                    <div class="no-search-results" style="display:none;">No matching projects.</div>

                </div>

            </div>

            <!-- Blockage / On Hold -->
            <div class="column">

                <div class="column-header">
                    <span class="status-dot dot-on-hold"></span>
                    <h2>On Hold</h2>
                </div>

                <div class="column-scroll">

                    @forelse ($onHoldProjects as $project)
                        <div class="project-card-link" data-project-id="{{ $project->id }}"
                            data-search="{{ strtolower(
                                $project->name .
                                    ' ' .
                                    ($project->description ?? '') .
                                    ' ' .
                                    $project->status .
                                    ' ' .
                                    ($project->creator?->fullname ?? ''),
                            ) }}">

                            <div class="project-card">

                                <div class="project-card-header">
                                    <div class="project-name">
                                        {{ $project->name }}
                                    </div>
                                </div>

                                <div class="project-card-body">

                                    <div class="project-id">
                                        PRJ-{{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}
                                    </div>

                                    <div class="project-desc">
                                        {{ $project->description ?? 'No project description.' }}
                                    </div>

                                    <div class="project-meta">

                                        <div class="meta-row">
                                            <svg viewBox="0 0 24 24">
                                                <path
                                                    d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0 2c-4.4 0-8 2.2-8 5v2h16v-2c0-2.8-3.6-5-8-5Z" />
                                            </svg>

                                            {{ $project->creator?->fullname ?? 'Unknown Admin' }}
                                        </div>

                                        <div class="meta-row">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M14.4 6 14 4H5v17h2v-7h5.6l.4 2h7V6z" />
                                            </svg>

                                            {{ $project->end_date?->format('d F Y') }}
                                        </div>

                                    </div>

                                    <span class="status-pill pill-on-hold">
                                        On Hold
                                    </span>

                                </div>

                            </div>
                        </div>

                    @empty

                        <div class="empty-projects">
                            No projects on hold.
                        </div>
                    @endforelse

                    <div class="no-search-results" style="display:none;">No matching projects.</div>

                </div>

            </div>

        </div>

        <div class="project-modal-overlay" id="project-modal">

            <div class="project-modal">

                <button type="button" class="project-modal-close" id="project-modal-close">
                    X
                </button>

                <div class="project-modal-header">

                    <h2 id="modal-project-name">
                        Project Name
                    </h2>

                    <span class="status-pill" id="modal-project-status">
                        Status
                    </span>

                </div>

                <div class="project-modal-content">

                    <div class="project-modal-details">

                        <div class="detail-grid">

                            <div class="detail-left">

                                <div class="detail-item">
                                    <span class="detail-label">
                                        Project ID
                                    </span>

                                    <strong id="modal-project-id"></strong>
                                </div>

                                <div class="detail-item">
                                    <span class="detail-label">
                                        Created By
                                    </span>

                                    <strong id="modal-project-creator"></strong>
                                </div>

                                <div class="detail-item">
                                    <span class="detail-label">
                                        Duration
                                    </span>

                                    <strong id="modal-project-duration"></strong>
                                </div>

                            </div>

                            <div class="detail-item assigned-developers">
                                <span class="detail-label">
                                    Assigned Developers
                                </span>

                                <div class="developer-avatars" id="modal-project-developers"></div>
                            </div>

                        </div>

                        <div class="detail-description">

                            <span class="detail-label">
                                Description
                            </span>

                            <strong id="modal-project-description"></strong>

                        </div>

                    </div>

                    <div class="milestone-panel">

                        <div class="milestone-title">
                            Milestones
                        </div>

                        <div class="milestone-list" id="modal-project-milestones"></div>

                        <form method="POST" id="milestone-form" class="milestone-comment-form">
                            @csrf

                            <textarea name="description" id="milestone-description" placeholder="Write a project update... Press Enter to post"
                                required></textarea>
                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>
    </div>

    <script>
        const currentUserId = {{ auth()->id() }};

        const milestoneStoreUrl = @json(route('developer.projects.milestones.store', ['project' => '__PROJECT__']));

        const milestoneDeleteUrl = @json(route('developer.projects.milestones.destroy', [
                'project' => '__PROJECT__',
                'milestone' => '__MILESTONE__',
            ]));

        const projectData = {{ Illuminate\Support\Js::from($projectData) }};

        document.addEventListener('DOMContentLoaded', function() {

            // ---------------- SEARCH ----------------

            const searchInput = document.getElementById('project-search');

            searchInput.addEventListener('input', function() {

                const searchValue = this.value.toLowerCase().trim();

                const columns = document.querySelectorAll('.column');

                columns.forEach(function(column) {

                    const projectCards =
                        column.querySelectorAll('.project-card-link');

                    const noResultsMessage =
                        column.querySelector('.no-search-results');

                    let visibleProjects = 0;

                    projectCards.forEach(function(card) {

                        const searchText =
                            card.dataset.search || '';

                        if (searchText.includes(searchValue)) {

                            card.style.display = '';
                            visibleProjects++;

                        } else {

                            card.style.display = 'none';

                        }

                    });

                    if (
                        searchValue !== '' &&
                        visibleProjects === 0 &&
                        projectCards.length > 0
                    ) {

                        noResultsMessage.style.display = 'block';

                    } else {

                        noResultsMessage.style.display = 'none';

                    }

                });

            });


            // ---------------- MODAL ----------------

            const projectCards = document.querySelectorAll('.project-card-link');

            const modal = document.getElementById('project-modal');

            const closeModalButton = document.getElementById('project-modal-close');

            const modalProjectName = document.getElementById('modal-project-name');

            const modalProjectId = document.getElementById('modal-project-id');

            const modalProjectStatus = document.getElementById('modal-project-status');

            const modalProjectCreator = document.getElementById('modal-project-creator');

            const modalProjectDevelopers = document.getElementById('modal-project-developers');

            const modalProjectDuration = document.getElementById('modal-project-duration');

            const modalProjectDescription = document.getElementById('modal-project-description');

            const modalProjectMilestones = document.getElementById('modal-project-milestones');

            const milestoneForm = document.getElementById('milestone-form');

            const milestoneDescription = document.getElementById('milestone-description');

            let currentProject = null;

            function addMilestoneToModal(milestone) {

                const emptyMessage = modalProjectMilestones.querySelector('.milestone-empty');

                if (emptyMessage) {
                    emptyMessage.remove();
                }

                const milestoneItem = document.createElement('div');

                milestoneItem.classList.add('milestone-item');

                const header = document.createElement('div');

                header.classList.add('milestone-comment-header');


                // Avatar

                const avatar = document.createElement('div');

                avatar.classList.add('milestone-avatar');

                const initials = milestone.user
                    .split(' ')
                    .map(function(name) {
                        return name.charAt(0);
                    })
                    .join('')
                    .substring(0, 2)
                    .toUpperCase();

                avatar.textContent = initials;


                // Developer information

                const userInfo = document.createElement('div');

                const userName = document.createElement('div');

                userName.classList.add('milestone-user');

                userName.textContent = milestone.user;


                const date = document.createElement('div');

                date.classList.add('milestone-date');

                date.textContent = milestone.created_at;


                userInfo.appendChild(userName);
                userInfo.appendChild(date);


                header.appendChild(avatar);
                header.appendChild(userInfo);


                // Description

                const description = document.createElement('div');

                description.classList.add('milestone-description');

                description.textContent = milestone.description;


                milestoneItem.appendChild(header);
                milestoneItem.appendChild(description);

                if (milestone.user_id === currentUserId) {

                    const deleteButton =
                        document.createElement('button');

                    deleteButton.type = 'button';

                    deleteButton.classList.add(
                        'milestone-delete-btn'
                    );

                    deleteButton.textContent = 'Delete';

                    deleteButton.addEventListener(
                        'click',
                        async function() {

                            if (
                                !confirm(
                                    'Delete this milestone comment?'
                                )
                            ) {
                                return;
                            }

                            const deleteUrl =
                                milestoneDeleteUrl
                                .replace(
                                    '__PROJECT__',
                                    currentProject.id
                                )
                                .replace(
                                    '__MILESTONE__',
                                    milestone.id
                                );

                            try {

                                const response = await fetch(
                                    deleteUrl, {
                                        method: 'DELETE',

                                        headers: {
                                            'Accept': 'application/json',

                                            'X-CSRF-TOKEN': document.querySelector(
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

                                milestoneItem.remove();

                                currentProject.milestones =
                                    currentProject.milestones.filter(
                                        function(item) {
                                            return item.id !== milestone.id;
                                        }
                                    );

                                if (
                                    currentProject.milestones.length === 0
                                ) {
                                    const emptyMessage =
                                        document.createElement('div');

                                    emptyMessage.classList.add(
                                        'milestone-empty'
                                    );

                                    emptyMessage.textContent =
                                        'No milestone updates yet.';

                                    modalProjectMilestones.appendChild(
                                        emptyMessage
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

                    milestoneItem.appendChild(
                        deleteButton
                    );
                }

                modalProjectMilestones.appendChild(
                    milestoneItem
                );


                // Automatically scroll to newest comment

                modalProjectMilestones.scrollTop =
                    modalProjectMilestones.scrollHeight;
            }

            projectCards.forEach(function(card) {

                card.addEventListener('click', function() {

                    const projectId = card.dataset.projectId;
                    const project = projectData[projectId];

                    if (!project) {
                        return;
                    }

                    currentProject = project;

                    milestoneForm.action = milestoneStoreUrl.replace('__PROJECT__', project.id);

                    milestoneDescription.value = '';


                    // Project name
                    modalProjectName.textContent = project.name;


                    // Project ID
                    modalProjectId.textContent =
                        'PRJ-' +
                        String(project.id).padStart(4, '0');


                    // Project status
                    modalProjectStatus.className = 'status-pill';

                    if (project.status === 'Not Started') {

                        modalProjectStatus.textContent = 'Not Started';

                        modalProjectStatus.classList.add('pill-not-started');

                    } else if (project.status === 'Ongoing') {

                        modalProjectStatus.textContent =
                            'Ongoing';

                        modalProjectStatus.classList.add(
                            'pill-ongoing'
                        );

                    } else if (project.status === 'Completed') {

                        modalProjectStatus.textContent =
                            'Completed';

                        modalProjectStatus.classList.add(
                            'pill-completed'
                        );

                    } else if (project.status === 'On Hold') {

                        modalProjectStatus.textContent =
                            'On Hold';

                        modalProjectStatus.classList.add(
                            'pill-on-hold'
                        );

                    }


                    // Created by
                    modalProjectCreator.textContent =
                        project.creator;


                    // Duration
                    modalProjectDuration.textContent =
                        project.start_date +
                        ' - ' +
                        project.end_date;


                    // Description
                    modalProjectDescription.textContent =
                        project.description;


                    // ---------------- DEVELOPERS ----------------

                    modalProjectDevelopers.innerHTML = '';

                    if (project.developers.length > 0) {

                        project.developers.forEach(function(developer) {

                            const avatar =
                                document.createElement('div');

                            avatar.classList.add(
                                'developer-avatar'
                            );

                            const initials = developer
                                .split(' ')
                                .map(function(name) {
                                    return name.charAt(0);
                                })
                                .join('')
                                .substring(0, 2)
                                .toUpperCase();

                            avatar.textContent =
                                initials;

                            avatar.title =
                                developer;

                            modalProjectDevelopers.appendChild(
                                avatar
                            );

                        });

                    } else {

                        modalProjectDevelopers.textContent =
                            'No developers assigned';

                    }


                    // ---------------- MILESTONES ----------------

                    modalProjectMilestones.innerHTML = '';

                    if (
                        project.milestones &&
                        project.milestones.length > 0
                    ) {

                        project.milestones.forEach(
                            function(milestone) {

                                addMilestoneToModal(
                                    milestone
                                );

                            }
                        );

                    } else {

                        const emptyMessage =
                            document.createElement('div');

                        emptyMessage.classList.add(
                            'milestone-empty'
                        );

                        emptyMessage.textContent =
                            'No milestone updates yet.';

                        modalProjectMilestones.appendChild(
                            emptyMessage
                        );

                    }

                    // Open modal
                    modal.classList.add('active');
                });
            });

            milestoneDescription.addEventListener('keydown', function(event) {

                if (event.key === 'Enter' && !event.shiftKey) {

                    event.preventDefault();

                    if (milestoneDescription.value.trim() === '') {
                        return;
                    }

                    milestoneForm.requestSubmit();
                }

            });

            milestoneForm.addEventListener('submit', async function(event) {

                event.preventDefault();

                const description =
                    milestoneDescription.value.trim();

                if (description === '') {
                    return;
                }

                const formData =
                    new FormData(milestoneForm);

                try {

                    const response = await fetch(
                        milestoneForm.action, {
                            method: 'POST',

                            headers: {
                                'Accept': 'application/json',
                            },

                            body: formData,
                        }
                    );

                    if (!response.ok) {
                        throw new Error(
                            'Unable to post milestone.'
                        );
                    }

                    const data = await response.json();

                    const milestone =
                        data.milestone;

                    addMilestoneToModal(milestone);

                    currentProject.milestones.push(milestone);

                    milestoneDescription.value = '';

                    milestoneDescription.focus();

                } catch (error) {

                    console.error(error);

                    alert(
                        'Unable to post milestone update.'
                    );

                }

            });


            // ---------------- CLOSE MODAL ----------------

            closeModalButton.addEventListener(
                'click',
                function() {

                    modal.classList.remove('active');

                }
            );

            modal.addEventListener(
                'click',
                function(event) {

                    if (event.target === modal) {

                        modal.classList.remove('active');

                    }

                }
            );

        });
    </script>

</body>

</html>
