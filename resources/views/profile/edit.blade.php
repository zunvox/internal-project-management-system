<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Setting</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        /* ---------- Page layout ---------- */

        .page {
            max-width: 1100px;
            margin: 0 auto;
            padding: 28px 24px 64px;
        }

        .card {
            background: white;
            border: 1px solid #2B6FFF;
            border-radius: 14px;
            box-shadow: 0 20px 50px rgba(43, 111, 255, 0.18);
        }

        .card-title {
            font-size: 24px;
            font-weight: 800;
            margin: 0;
            padding: 22px 28px 16px;
        }

        hr.divider {
            border: none;
            border-top: 1px solid #E4E7EC;
            margin: 0;
        }

        .section {
            padding: 22px 28px;
        }

        .section-label {
            font-size: 15px;
            font-weight: 700;
            margin: 0 0 18px;
        }

        /* ---------- Profile picture ---------- */

        .picture-row {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .avatar {
            width: 90px;
            height: 90px;
            min-width: 56px;
            border-radius: 50%;
            border: 2px solid black;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar svg {
            width: 34px;
            height: 34px;
            fill: black;
        }

        .picture-info {
            flex: 1;
        }

        .name-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .name-row .name {
            font-size: 15px;
            font-weight: 700;
        }

        .role-badge {
            background: #EAF6FC;
            border: 1px solid #29a3f0;
            color: #0F7FB0;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 999px;
        }

        .member-since {
            font-size: 12px;
            color: #98A2B3;
            margin-top: 4px;
        }

        .picture-actions {
            text-align: right;
        }

        .picture-hint {
            font-size: 11px;
            color: #98A2B3;
            margin-top: 6px;
        }

        /* ---------- Buttons ---------- */

        .btn {
            border-radius: 5px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            padding: 9px 22px;
        }

        .btn-outline-blue {
            background: white;
            border: 1px solid #019BEF;
            color: #019BEF;
        }

        .btn-outline-blue:hover {
            background: #EFF4FF;
        }

        .btn-outline-blue:disabled {
            opacity: 0.5;
            cursor: default;
        }

        .btn-outline-gray {
            background: white;
            border: 1px solid #D0D5DD;
            color: #667085;
        }

        .btn-outline-gray:hover {
            background: #F9FAFB;
        }

        .btn-outline-red {
            background: white;
            border: 1px solid #F04438;
            color: #F04438;
        }

        .btn-outline-red:hover {
            background: #FEF3F2;
        }

        /* ---------- Personal info form ---------- */

        .form-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            column-gap: 40px;
            row-gap: 24px;
            margin-bottom: 22px;
        }

        .form-field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-field label {
            font-size: 14px;
            font-weight: 700;
            color: #101828;
        }

        .form-field input,
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
            min-height: 64px;
            font-family: 'Inter', system-ui, sans-serif;
        }

        .form-field input:focus,
        .form-field textarea:focus {
            border-color: #3538CD;
            box-shadow: 0 0 0 4px rgba(53, 56, 205, 0.14);
        }

        .field-full-name {
            grid-column: 1;
        }

        .field-dev-id {
            grid-column: 2;
        }

        .field-email {
            grid-column: 3;
        }

        .field-username {
            grid-column: 4;
        }

        .field-role {
            grid-column: 1;
        }

        .field-phone {
            grid-column: 2;
        }

        .field-address {
            grid-column: 3 / span 2;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
        }

        .field-error {
            color: #F04438;
            font-size: 12px;
            margin-top: 2px;
        }

        .success-message {
            margin: 0 28px 20px;
            padding: 12px 16px;
            border: 1px solid #12B76A;
            background: #ECFDF3;
            color: #027A48;
            border-radius: 8px;
            font-size: 13px;
            opacity: 1;
            transition: opacity 0.4s ease;
        }

        .success-message.hide {
            opacity: 0;
        }

        /* ---------- Security / Delete rows ---------- */

        .setting-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .setting-row .label {
            font-size: 15px;
            color: #101828;
        }

        .password-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .password-input-wrapper {
            position: relative;
            width: 100%;
        }

        .password-input-wrapper input {
            width: 100%;
            box-sizing: border-box;
            padding-right: 44px;
        }

        .password-toggle-btn {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            background: none;
            border: none;
            cursor: pointer;
        }

        .eye-icon {
            font-size: 16px;
            line-height: 1;
            opacity: 0.6;
        }

        .password-toggle-btn:hover .eye-icon {
            opacity: 1;
        }
    </style>
</head>

<body>

    @if ($user->role === 'Admin')
        @include('admin.partials.admin-topbar')
        @include('admin.partials.admin-nav')
    @else
        @include('developer.partials.developer-topbar')
        @include('developer.partials.developer-nav')
    @endif

    <div class="stage">
        <div class="page">
            <div class="card">
                <h1 class="card-title">User Profile</h1>
                <hr class="divider">

                @if (session('success'))
                    <div class="success-message" id="success-message">{{ session('success') }}</div>
                @endif

                <!-- Profile Picture -->
                <div class="section">
                    <h2 class="section-label">Profile Picture</h2>

                    <div class="picture-row">

                        <div class="avatar">

                            @if ($user->profile_picture)
                                <img id="profile-preview" src="{{ asset('storage/' . $user->profile_picture) }}"
                                    alt="Profile Picture"
                                    style="
                                width:100%;
                                height:100%;
                                object-fit:cover;
                                border-radius:50%;
                            ">

                                <svg id="default-avatar" viewBox="0 0 24 24" style="display:none;">
                                    <path
                                        d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0 2c-4.4 0-8 2.2-8 5v2h16v-2c0-2.8-3.6-5-8-5Z" />
                                </svg>
                            @else
                                <img id="profile-preview" src="" alt="Profile Picture"
                                    style="
                                width:100%;
                                height:100%;
                                object-fit:cover;
                                border-radius:50%;
                                display:none;
                            ">

                                <svg id="default-avatar" viewBox="0 0 24 24">
                                    <path
                                        d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0 2c-4.4 0-8 2.2-8 5v2h16v-2c0-2.8-3.6-5-8-5Z" />
                                </svg>
                            @endif

                        </div>

                        <div class="picture-info">

                            <div class="name-row">
                                <span class="name">
                                    {{ $user->username ?: $user->fullname }}
                                </span>

                                <span class="role-badge">
                                    {{ $user->role }}
                                </span>
                            </div>

                            <div class="member-since">
                                Member since {{ $user->created_at->format('F Y') }}
                            </div>

                        </div>

                        <div class="picture-actions">

                            <button class="btn btn-outline-blue" id="change-photo-button" type="button">
                                Change Photo
                            </button>

                            <div class="picture-hint">
                                JPG or PNG, max 2MB
                            </div>

                        </div>

                    </div>
                </div>

                <hr class="divider">

                <form id="profile-form" action="{{ route('profile.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input id="profile-picture-input" type="file" name="profile_picture" accept=".jpg,.jpeg,.png"
                        hidden>

                    <!-- Personal Info -->
                    <div class="section">

                        <h2 class="section-label">Personal Info</h2>

                        <div class="form-grid">

                            <div class="form-field field-full-name">
                                <label for="fullname">Full Name</label>

                                <input id="fullname" name="fullname" type="text"
                                    value="{{ old('fullname', $user->fullname) }}" required>

                                @error('fullname')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-field field-dev-id">

                                <label for="userid">
                                    {{ $user->role === 'Admin' ? 'Admin ID' : 'Developer ID' }}
                                </label>

                                <input id="userid" type="text" value="{{ $user->userid }}" disabled>

                            </div>


                            <div class="form-field field-email">

                                <label for="email">Email Address</label>

                                <input id="email" name="email" type="email"
                                    value="{{ old('email', $user->email) }}" required>

                                @error('email')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror

                            </div>


                            <div class="form-field field-username">

                                <label for="username">Username</label>

                                <input id="username" name="username" type="text"
                                    value="{{ old('username', $user->username) }}">

                                @error('username')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror

                            </div>


                            <div class="form-field field-role">

                                <label for="role">Role</label>

                                <input id="role" type="text" value="{{ $user->role }}" disabled>

                            </div>


                            <div class="form-field field-phone">

                                <label for="phone">Phone Number</label>

                                <input id="phone" name="phone" type="text"
                                    value="{{ old('phone', $user->phone) }}">

                                @error('phone')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror

                            </div>


                            <div class="form-field field-address">

                                <label for="address">Address</label>

                                <textarea id="address" name="address">{{ old('address', $user->address) }}</textarea>

                                @error('address')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror

                            </div>

                        </div>


                        <div class="form-actions">

                            <button class="btn btn-outline-blue" type="submit">
                                Save Changes
                            </button>

                        </div>

                    </div>
                </form>

                <hr class="divider">

                <!-- Security -->
                <div class="section">
                    <h2 class="section-label">Security</h2>

                    <div class="setting-row">
                        <span class="label">Change Password</span>

                        <button class="btn btn-outline-gray" id="password-toggle" type="button">
                            Update
                        </button>
                    </div>

                    <div id="password-panel" style="display:none; margin-top:22px;">
                        <form action="{{ route('profile.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="password-grid">

                                <div class="form-field">
                                    <label for="current_password">
                                        Current Password
                                    </label>

                                    <div class="password-input-wrapper">

                                        <input id="current_password" name="current_password" type="password">
                                        <button class="password-toggle-btn" type="button"
                                            data-target="current_password" aria-label="Show password">
                                            <span class="eye-icon">👁</span>
                                        </button>

                                    </div>

                                    @error('current_password')
                                        <span class="field-error">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>


                                <div class="form-field">
                                    <label for="password">
                                        New Password
                                    </label>

                                    <div class="password-input-wrapper">

                                        <input id="password" name="password" type="password">
                                        <button class="password-toggle-btn" type="button" data-target="password"
                                            aria-label="Show password">
                                            <span class="eye-icon">👁</span>
                                        </button>

                                    </div>

                                    @error('password')
                                        <span class="field-error">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>


                                <div class="form-field">
                                    <label for="password_confirmation">
                                        Confirm New Password
                                    </label>

                                    <div class="password-input-wrapper">

                                        <input id="password_confirmation" name="password_confirmation"
                                            type="password">
                                        <button class="password-toggle-btn" type="button"
                                            data-target="password_confirmation" aria-label="Show password">
                                            <span class="eye-icon">👁</span>
                                        </button>

                                    </div>
                                </div>

                            </div>

                            <div class="form-actions" style="margin-top:20px;">
                                <button class="btn btn-outline-blue" type="submit">
                                    Update Password
                                </button>
                            </div>

                        </form>
                    </div>
                </div>


                <hr class="divider">


                <!-- Delete Account -->
                <div class="section">

                    <div class="setting-row">
                        <span class="label">Delete Account</span>

                        <button class="btn btn-outline-red" id="delete-toggle" type="button">
                            Delete
                        </button>
                    </div>

                    <div id="delete-panel" style="display:none; margin-top:22px;">

                        <form id="delete-account-form" action="{{ route('profile.destroy') }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <div class="form-field">

                                <label for="delete_password">
                                    Enter your password to confirm
                                </label>

                                <input id="delete_password" name="delete_password" type="password">

                                @error('delete_password')
                                    <span class="field-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                            <div class="form-actions" style="margin-top:20px;">
                                <button class="btn btn-outline-red" type="submit">
                                    Confirm Delete Account
                                </button>
                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const changePhotoButton = document.getElementById('change-photo-button');
            const profilePictureInput = document.getElementById('profile-picture-input');
            const profilePreview = document.getElementById('profile-preview');
            const defaultAvatar = document.getElementById('default-avatar');
            const passwordToggle = document.getElementById('password-toggle');
            const passwordPanel = document.getElementById('password-panel');
            const deleteToggle = document.getElementById('delete-toggle');
            const deletePanel = document.getElementById('delete-panel');
            const deleteAccountForm = document.getElementById('delete-account-form');

            changePhotoButton.addEventListener('click', function() {
                profilePictureInput.click();
            });

            profilePictureInput.addEventListener('change', function() {
                const file = this.files[0];
                if (!file) {
                    return;
                }

                const allowedTypes = ['image/jpeg', 'image/png'];

                if (!allowedTypes.includes(file.type)) {
                    alert('Please select a JPG or PNG image.');
                    this.value = '';

                    return;
                }

                const maxSize = 2 * 1024 * 1024;

                if (file.size > maxSize) {
                    alert('Profile picture must not exceed 2MB.');
                    this.value = '';

                    return;
                }

                const reader = new FileReader();

                reader.onload = function(event) {
                    profilePreview.src = event.target.result;
                    profilePreview.style.display = 'block';
                    if (defaultAvatar) {
                        defaultAvatar.style.display = 'none';
                    }
                };

                reader.readAsDataURL(file);
            });

            passwordToggle.addEventListener('click', function() {
                const isHidden = passwordPanel.style.display === 'none';
                passwordPanel.style.display = isHidden ? 'block' : 'none';
                passwordToggle.textContent = isHidden ? 'Cancel' : 'Update';
            });

            deleteToggle.addEventListener('click', function() {
                const isHidden = deletePanel.style.display === 'none';
                deletePanel.style.display = isHidden ? 'block' : 'none';
                deleteToggle.textContent = isHidden ? 'Cancel' : 'Delete';
            });

            deleteAccountForm.addEventListener('submit', function(event) {
                const confirmed = confirm(
                    'Are you sure you want to delete your account? You will no longer be able to access the system.'
                    );
                if (!confirmed) {
                    event.preventDefault();
                }
            });

            const successMessage = document.getElementById('success-message');

            if (successMessage) {
                setTimeout(function() {

                    successMessage.classList.add('hide');

                    setTimeout(function() {
                        successMessage.remove();
                    }, 400);

                }, 5000);
            }

            const passwordPreviewButtons = document.querySelectorAll('.password-toggle-btn');

            passwordPreviewButtons.forEach(function(button) {

                button.addEventListener('click', function() {

                    const targetId = button.dataset.target;
                    const passwordInput = document.getElementById(targetId);

                    if (!passwordInput) {
                        return;
                    }

                    const isPassword =
                        passwordInput.type === 'password';

                    passwordInput.type =
                        isPassword ? 'text' : 'password';

                    button.setAttribute(
                        'aria-label',
                        isPassword ? 'Hide password' : 'Show password'
                    );

                });

            });

        });
    </script>

</body>

</html>
