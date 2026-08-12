<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password — Syedn Tech Solution</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
  
  *{
    box-sizing:border-box;
}
  html, body{
    height:100%;
}

  body{
    margin:0;
    display:flex;
    flex-direction:column;
    font-family:'Inter',system-ui,sans-serif;
    color:black;
    min-height: 100pv;
    
  }

  .topbar{
    background:black;
    padding:16px 0;
    text-align:center;
  }

  .topbar-brand{
    font-size:17px;
    font-weight:700;
    letter-spacing:0.08em;
    color:#5B8DEF;
    text-transform:uppercase;
  }

  .stage{
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    background-color: #6E9DFD;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
  }

  .frame{
    width:100%;
    max-width:600px;
    background:white;
    border-radius: 39px;
    margin: 0px 0px;
    display: flex;
    padding:20px 0px;
    box-shadow:0 20px 50px rgba(43,49,120,0.18);    
  }

  .reset-card{
    border-radius:16px;
    width: 75%;
    margin: 0 auto;
    padding:36px 0px 28px;
  }

  .reset-heading{
    text-align:center;
    font-size:30px;
    font-weight:700;
    letter-spacing:0.01em;
    margin:0 0 8px;
  }
  
  .reset-sub{
    text-align:center;
    font-size:20px;
    letter-spacing: 0.02em;
    color:#959595;
    margin:0 0 28px;
    line-height:1.5;
  }

  .field {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin-bottom: 20px;
}

.field label {
  font-size: 16px;
  font-weight: 700;
  color: black;
}

.field input {
  width: 100%;
  padding: 12px 16px;
  font-size: 13px;
  font-family: 'Inter',system-ui,sans-serif;
  color: black;
  background-color: rgba(255,255,255,0.25);
  border: 1px solid rgba(22,22,22,0.50);
  border-radius: 12px;
  outline: none;
  box-shadow:0 5px 3px rgba(43,49,120,0.18);    
  transition: border-color 0.15s ease, box-shadow 0.15s ease;
}

.field input::placeholder {
  color: rgba(22,22,22,0.50);
}

.field input:focus {
  border-color: rgba(22,22,22,0.50);
  box-shadow: 0 0 0 4px rgba(53, 56, 205, 0.14);
}

  .confirm-btn{
    width:100%;
    margin-top:60px;
    margin-bottom: -100px;
    padding:20px;
    border:none;
    border-radius:999px;
    background: #62C8FF;
    color: black;
    font-size:15px;
    cursor:pointer;
  }
</style>

</head>

<body>

  <div class= "topbar">
    <span class = "topbar-brand">Syedn Tech Solution</span>
  </div>

  <div class = "stage">
    <div class = "frame">
      <div class = "reset-card">
        <h1 class = "reset-heading">Reset Password</h1>
        <p class = "reset-sub">Please set your new password</p>

        @if ($errors->any())
          <div id="reset-error" style="color:red; text-align:center; font-size:13px; margin-bottom:16px;">

            @foreach ($errors->all() as $error)
              <p style="margin:4px 0;">{{ $error }}</p>
            @endforeach
          </div>
        @endif

        <p id="client-password-error" style="display:none; color:red; text-align:center; font-size:13px; margin-bottom:16px;"></p>

        <form id = "reset-password-form" method = "POST" action = "{{ route('password.update') }}">
          @csrf

          {{-- The reset token comes from the email link --}}
          <input type="hidden" name="token" value="{{ $token }}" >

          {{-- Email carried by the reset link but not shown --}}
          <input type="hidden" name="email" value="{{ old('email', $email) }}" >

          <div class = "field">
            <label for="newpass">New Password</label>
            <input id = "newpass" name = "password" type = "password" required>
          </div>

          <div class = "field">
            <label for="enternewpass">Re-enter Password</label>
            <input id = "enternewpass" name = "password_confirmation" type = "password" required>
          </div>

            <div class = "confirmation-btn">
            <button  id = "confirm-button" class = "confirm-btn" type = "submit">Confirm Password</button>
            </div>
        </form>
      
      </div>
    </div>
  </div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('reset-password-form');
    const passwordInput = document.getElementById('newpass');
    const confirmationInput = document.getElementById('enternewpass');
    const errorMessage = document.getElementById('client-password-error');
    const button = document.getElementById('confirm-button');

    function displayError(message) {
      errorMessage.textContent = message;
      errorMessage.style.display = 'block';
    }

    function clearError() {
      errorMessage.textContent = '';
      errorMessage.style.display = 'none';
    }

    // Check confirmation while the user is typing.
    confirmationInput.addEventListener('input', function () {
      if (
        confirmationInput.value !== '' &&
        passwordInput.value !== confirmationInput.value
      ) {
        displayError('The passwords do not match.');
      } else {
        clearError();
      }
    });

    passwordInput.addEventListener('input', function () {
      if (
        confirmationInput.value !== '' &&
        passwordInput.value !== confirmationInput.value
      ) {
        displayError('The passwords do not match.');
      } else {
        clearError();
      }
    });

    form.addEventListener('submit', function (event) {
      clearError();

      if (passwordInput.value.length < 8) {
        event.preventDefault();
        displayError('The password must contain at least 8 characters.');
        passwordInput.focus();
        return;
      }

      if (passwordInput.value !== confirmationInput.value) {
        event.preventDefault();
        displayError('The passwords do not match.');
        confirmationInput.focus();
        return;
      }

      // Prevent multiple submissions after validation passes.
      button.disabled = true;
      button.textContent = 'Updating Password...';
    });

    const serverError = document.getElementById('reset-error');

    if (serverError) {
      setTimeout(function () {
        serverError.remove();
      }, 7000);
    }
  });
</script>

</body>
</html>