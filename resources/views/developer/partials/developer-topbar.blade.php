@auth
    <div class="topbar">
        <div class="topbar-right">
            <div class="profile-menu">

                <button class="profile-btn" id="profile-menu-button" type="button" aria-expanded="false">
                    <span class="profile-avatar">

                        @if (auth()->user()->profile_picture)
                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile">
                        @else
                            {{ strtoupper(substr(auth()->user()->username ?: auth()->user()->fullname, 0, 1)) }}
                        @endif

                    </span>
                    <span class="profile-name"> {{ auth()->user()->username ?: auth()->user()->fullname }}</span>
                </button>

                <div class="profile-dropdown" id="profile-dropdown">

                    <a href="{{ route('profile.edit') }}" class="profile-dropdown-item">
                        <span>Profile</span>
                        <span class="dropdown-icon">👤</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}">

                        @csrf

                        <button type="submit" class="profile-dropdown-item">
                            <span>Log Out</span>
                            <span class="dropdown-icon">↪</span>
                        </button>

                    </form>

                </div>
            </div>
        </div>
        <span class="topbar-brand">Syedn Tech Solution</span>
    </div>
@endauth

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profileButton = document.getElementById('profile-menu-button');
        const profileDropdown = document.getElementById('profile-dropdown');

        if (!profileButton || !profileDropdown) {
            return;
        }

        profileButton.addEventListener('click', function(event) {
            event.stopPropagation();
            profileDropdown.classList.toggle('show');
            const isOpen = profileDropdown.classList.contains('show');
            profileButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        document.addEventListener('click', function(event) {
            if (!profileButton.contains(event.target) && !profileDropdown.contains(event.target)) {
                profileDropdown.classList.remove('show');
                profileButton.setAttribute('aria-expanded', 'false');
            }
        });
    });
</script>
