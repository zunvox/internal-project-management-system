<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Project Index</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>

.page{
    width:100%;
    max-width:1400px;
    margin:0 auto;
    padding:18px 38px 0;
    box-sizing:border-box;
  }
 
  .page-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:16px;
    padding-bottom:14px;
    border-bottom:1px solid #D0D5DD;
  }
 
  .page-title{
    font-size:32px;
    font-weight:800;
    margin:0;
    color:#101828;
  }
 
  .btn-primary{
    background:#019BEF;
    color:white;
    border:none;
    padding:8px 18px;
    border-radius:7px;
    font-size:14px;
    font-weight:500;
    cursor:pointer;
    box-shadow:none;
    text-decoration:none;
    display:inline-block;
  }
 
  .btn-primary:hover{
    background:rgb(56, 111, 239);
  }
 
  /* ---------- Search ---------- */
 
  .search-field{
    position:relative;
    max-width:185px;
    margin-bottom:16px;
  }
 
  .search-field svg{
    position:absolute;
    left:7px;
    top:50%;
    transform:translateY(-50%);
    width:11px;
    height:11px;
    fill:#98A2B3;
  }
 
  .search-field input{
    width:100%;
    height:20px;
    padding:2px 8px 2px 22px;
    font-size:10px;
    font-family:'Inter',system-ui,sans-serif;
    border:1px solid #BFC4CC;
    border-radius: 7px;
    outline:none;
    background:white;
  }
 
  .search-field input::placeholder{
    color:#98A2B3;
  }
 
  .search-field input:focus{
    border-color:#3538CD;
    box-shadow:0 0 0 4px rgba(53, 56, 205, 0.14);
  }

  .no-search-results{
    font-size:11px;
    color:#98A2B3;
    text-align:center;
    padding:16px 8px;
}
 
  /* ---------- Board ---------- */
 
  .board{
    display:grid;
    grid-template-columns:repeat(5, minmax(0, 1fr));
    gap:10px;
    align-items:start;
  }
 
  .column-header{
    display:flex;
    align-items:center;
    gap:6px;
    padding-bottom:7px;
    border-bottom:1px solid #D0D5DD;
    margin-bottom:10px;
  }

  .column-header h2{
    font-size:14px;
    font-weight:700;
    margin:0;
  }
 
  .status-dot{
    width:16px;
    height:16px;
    border-radius:50%;
    position:relative;
  }
 
  .dot-not-started{ background:#E9C24C; }
  .dot-ongoing{ background:#64D3EB; }
  .dot-completed{ background:#5FE287; }
  .dot-on-hold{ background:#FF8A8A; }
  .dot-cancelled{ background:#C8C8C8; }

  .status-dot::after{
    content:'';
    width:5px;
    height:5px;
    border-radius:50%;
    background:#333;
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
  }
 
  .column-header h2{
    font-size:15px;
    font-weight:700;
    margin:0;
  }
 
  .column-scroll{
    max-height:calc(100vh - 260px);
    overflow-y:auto;
    padding-right:6px;
    display:flex;
    flex-direction:column;
    gap:12px;
  }
 
  .column-scroll::-webkit-scrollbar{
    width:8px;
  }
 
  .column-scroll::-webkit-scrollbar-track{
    background:#EAF0FF;
    border-radius:8px;
  }
 
  .column-scroll::-webkit-scrollbar-thumb{
    background:#98A2B3;
    border-radius:8px;
  }
 
  /* ---------- Project card ---------- */
 
  .project-card{
    background:white;
    border:1px solid #2B6FFF;
    border-radius:12px;
    padding:0;
    overflow:hidden;
    box-shadow:0 5px 10px rgba(43,111,255,0.28);
    transition:transform 0.15s ease;
    flex-shrink:0;
  }
 
  .project-card.selected{
    background:#2B6FFF;
    border-color:#2B6FFF;
  }

  .project-card-header{
    background:#8FAFF2;
    padding:8px 10px;
    text-align:center;
  }

  .project-card.selected .project-card-header{
    background:#2B6FFF;
}

.project-card-link{
    text-decoration:none;
    color:inherit;
    display:block;
}

.project-card-link:hover .project-card{
    transform:translateY(-2px);
}

  .project-card-body{
    padding:6px 8px 14px;
  }
 
  .project-name{
    font-size:12px;
    font-weight:700;
    color:#101828;
    margin:0;
  }
 
  .project-card.selected .project-name{
    color:white;
  }
 
  .project-id{
    font-size:10px;
    font-weight:700;
    color:#2B6FFF;
    margin-bottom:4px;
  }
 
  .project-card.selected .project-id{
    color:#D1E9FF;
  }
 
  .project-desc{
    font-size:10px;
    color:#98A2B3;
    line-height:1.35;
    margin-bottom:12px;
  }
 
  .project-card.selected .project-desc{
    color:#E4E7EC;
  }

  .empty-projects{
    font-size:11px;
    font-weight:400;
    color:#98A2B3;
    padding:8px 4px;
}
 
  .project-meta{
    display:flex;
    flex-direction:column;
    gap:2px;
    margin-bottom:4px;
  }
 
  .meta-row{
    display:flex;
    align-items:center;
    gap:4px;
    font-size:10px;
    color:#475467;
  }
 
  .project-card.selected .meta-row{
    color:#E4E7EC;
  }
 
  .meta-row svg{
    width:12px;
    height:12px;
    fill:#667085;
  }
 
  .project-card.selected .meta-row svg{
    fill:#E4E7EC;
  }
 
  .status-pill{
    display:inline-block;
    padding:2px 12px;
    border-radius:999px;
    font-size:9px;
    font-weight:500;
  }
 
  .pill-not-started{ background:#FEF0C7; color:#B54708; }
  .pill-ongoing{ background:#D1E9FF; color:#175CD3; }
  .pill-completed{ background:#D3F8DF; color:#1A7F37; }
  .pill-on-hold{ background:#FEE4E2; color:#D92D20; }
  .pill-cancelled{ background:#EAECF0; color:#667085; }
 
  .project-card.selected .status-pill{
    background:rgba(255,255,255,0.85);
  }

</style>

</head>

<body>

    @include('admin.partials.admin-topbar')
    @include('admin.partials.admin-nav')

    <div class="page">
 
  <div class="page-header">
    <h1 class="page-title">Project Index</h1>
    <a href="{{ route('admin.projects.create') }}" class="btn-primary">+ New Project</a>
  </div>
 
  <div class="search-field">
    <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27a6.47 6.47 0 0 0 1.57-4.23 6.5 6.5 0 1 0-6.5 6.5c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5Zm-6 0A4.5 4.5 0 1 1 14 9.5 4.5 4.5 0 0 1 9.5 14Z"/></svg>
    <input type="text" id="project-search" placeholder="Search...">
  </div>
 
  <div class="board">
 
    <!-- Not Started -->
    <div class="column">
      <div class="column-header">
        <span class="status-dot dot-not-started"></span>
        <h2>Not Started</h2>
      </div>
      <div class="column-scroll">

        @forelse ($notStartedProjects as $project)
        <a href="{{ route('admin.projects.edit', $project) }}" class="project-card-link" data-search="{{ strtolower(
        $project->name . ' ' .
        ($project->description ??'') . ' ' .
        $project->status . ' ' .
        ($project->creator?->fullname ?? '')) }}">
        
        <div class="project-card">
          <div class="project-card-header">
            <div class="project-name">{{ $project->name }}</div>
          </div>
          <div class="project-card-body">
            <div class="project-id">PRJ-{{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}</div>
            <div class="project-desc">{{ $project->description ?? 'No project description.' }}</div>
            <div class="project-meta">

                <div class="meta-row">
                  <svg viewBox="0 0 24 24"><path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0 2c-4.4 0-8 2.2-8 5v2h16v-2c0-2.8-3.6-5-8-5Z"/></svg>
                  {{ $project->creator?->fullname ?? 'Unknown Admin' }}
                </div>
                
              <div class="meta-row">
                <svg viewBox="0 0 24 24"><path d="M14.4 6 14 4H5v17h2v-7h5.6l.4 2h7V6z"/></svg>
                {{ $project->end_date?->format('d F Y') }}
              </div>

              </div>
              <span class="status-pill pill-not-started">Not Started</span>
              </div>
            </div>
          </a>

        @empty

          <div class="empty-projects">No projects found.</div>

        @endforelse

        <div class="no-search-results" style="display:none;">No matching projects.</div>
      </div>
    </div>

    <!-- Ongoing -->
    <div class="column">


      <div class="column-header">
        <span class="status-dot dot-ongoing"></span>
        <h2>Ongoing</h2>
      </div>

      <div class="column-scroll">

          @forelse ($ongoingProjects as $project)

          <a href="{{ route('admin.projects.edit', $project) }}" class="project-card-link" data-search="{{ strtolower(
          $project->name . ' ' .
          ($project->description ??'') . ' ' .
          $project->status . ' ' .
          ($project->creator?->fullname ?? '')) }}">

              <div class="project-card">

                  <div class="project-card-header">
                      <div class="project-name">{{ $project->name }}</div>
                  </div>

                  <div class="project-card-body">

                      <div class="project-id">PRJ-{{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}</div>

                      <div class="project-desc">{{ $project->description ?? 'No project description.' }}</div>

                      <div class="project-meta">

                          <div class="meta-row">
                              <svg viewBox="0 0 24 24"><path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0 2c-4.4 0-8 2.2-8 5v2h16v-2c0-2.8-3.6-5-8-5Z"/></svg>
                              {{ $project->creator?->fullname ?? 'Unknown Admin' }}
                          </div>

                          <div class="meta-row">
                              <svg viewBox="0 0 24 24"><path d="M14.4 6 14 4H5v17h2v-7h5.6l.4 2h7V6z"/></svg>
                              {{ $project->end_date?->format('d F Y') }}
                          </div>

                      </div>
                      <span class="status-pill pill-ongoing">Ongoing</span>
                  </div>
              </div>
            </a>

          @empty

              <div class="empty-projects">No ongoing projects.</div>

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

              <a href="{{ route('admin.projects.edit', $project) }}" class="project-card-link" data-search="{{ strtolower(
              $project->name . ' ' .
              ($project->description ??'') . ' ' .
              $project->status . ' ' .
              ($project->creator?->fullname ?? '')) }}">

                  <div class="project-card">

                      <div class="project-card-header">
                          <div class="project-name">{{ $project->name }}</div>
                      </div>

                      <div class="project-card-body">

                          <div class="project-id">PRJ-{{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}</div>

                          <div class="project-desc">{{ $project->description ?? 'No project description.' }}</div>

                          <div class="project-meta">

                              <div class="meta-row">
                                  <svg viewBox="0 0 24 24"><path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0 2c-4.4 0-8 2.2-8 5v2h16v-2c0-2.8-3.6-5-8-5Z"/></svg>
                                  {{ $project->creator?->fullname ?? 'Unknown Admin' }}
                              </div>

                              <div class="meta-row">
                                  <svg viewBox="0 0 24 24"><path d="M14.4 6 14 4H5v17h2v-7h5.6l.4 2h7V6z"/></svg>
                                  {{ $project->end_date?->format('d F Y') }}
                              </div>

                          </div>
                          <span class="status-pill pill-completed">Completed</span>
                      </div>

                  </div>
                </a>

              @empty

                  <div class="empty-projects">No completed projects.</div>

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

              <a href="{{ route('admin.projects.edit', $project) }}" class="project-card-link" data-search="{{ strtolower(
              $project->name . ' ' .
              ($project->description ??'') . ' ' .
              $project->status . ' ' .
              ($project->creator?->fullname ?? '')) }}">
              
                  <div class="project-card">

                      <div class="project-card-header">
                          <div class="project-name">{{ $project->name }}</div>
                      </div>

                      <div class="project-card-body">

                          <div class="project-id">PRJ-{{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}</div>

                          <div class="project-desc">{{ $project->description ?? 'No project description.' }}</div>

                          <div class="project-meta">

                              <div class="meta-row">
                                  <svg viewBox="0 0 24 24"><path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0 2c-4.4 0-8 2.2-8 5v2h16v-2c0-2.8-3.6-5-8-5Z"/></svg>
                                  {{ $project->creator?->fullname ?? 'Unknown Admin' }}
                              </div>

                              <div class="meta-row">
                                  <svg viewBox="0 0 24 24"><path d="M14.4 6 14 4H5v17h2v-7h5.6l.4 2h7V6z"/></svg>
                                  {{ $project->end_date?->format('d F Y') }}
                              </div>

                          </div>
                          <span class="status-pill pill-on-hold">On Hold</span>
                      </div>

                  </div>
                </a>

              @empty

                  <div class="empty-projects">No projects on hold.</div>

              @endforelse

              <div class="no-search-results" style="display:none;">No matching projects.</div>
          </div>
      </div>

      <!-- Cancelled -->
      <div class="column">

          <div class="column-header">
              <span class="status-dot dot-cancelled"></span>
              <h2>Cancelled</h2>
          </div>

          <div class="column-scroll">

              @forelse ($cancelledProjects as $project)

              <a href="{{ route('admin.projects.edit', $project) }}" class="project-card-link" data-search="{{ strtolower(
              $project->name . ' ' .
              ($project->description ??'') . ' ' .
              $project->status . ' ' .
              ($project->creator?->fullname ?? '')) }}">
              
                  <div class="project-card">

                      <div class="project-card-header">
                          <div class="project-name">{{ $project->name }}</div>
                      </div>

                      <div class="project-card-body">

                          <div class="project-id">PRJ-{{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}</div>

                          <div class="project-desc">{{ $project->description ?? 'No project description.' }}</div>

                          <div class="project-meta">

                              <div class="meta-row">
                                  <svg viewBox="0 0 24 24"><path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0 2c-4.4 0-8 2.2-8 5v2h16v-2c0-2.8-3.6-5-8-5Z"/></svg>
                                  {{ $project->creator?->fullname ?? 'Unknown Admin' }}
                              </div>

                              <div class="meta-row">
                                  <svg viewBox="0 0 24 24"><path d="M14.4 6 14 4H5v17h2v-7h5.6l.4 2h7V6z"/></svg>
                                  {{ $project->end_date?->format('d F Y') }}
                              </div>

                          </div>
                          <span class="status-pill pill-cancelled">Cancelled</span>
                      </div>

                  </div>
                </a>
              @empty

                  <div class="empty-projects">No cancelled projects.
                  </div>

              @endforelse

              <div class="no-search-results" style="display:none;">No matching projects.</div>
          </div>
      </div>

  </div>
 
  </div>
</div>
 
<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('project-search');

    searchInput.addEventListener('input', function () {

        const searchValue = this.value.toLowerCase().trim();

        const columns = document.querySelectorAll('.column');

        columns.forEach(function (column) {

            const projectCards = column.querySelectorAll('.project-card-link');
            const noResultsMessage = column.querySelector('.no-search-results');

            let visibleProjects = 0;

            projectCards.forEach(function (card) {

                const searchText = card.dataset.search || '';

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

});
</script>

</body>
</html>