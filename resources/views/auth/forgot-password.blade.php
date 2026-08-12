<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password — Syedn Tech Solution</title>
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
    align-items: stretch;
    justify-content: flex-start;
    padding: 0;
    background-image: url(https://img.magnific.com/free-photo/vivid-blurred-colorful-wallpaper-background_58702-3883.jpg?semt=ais_test_b&w=740&q=80);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
  }

  .frame{
    width:50%;
    max-width:600px;
    background:rgba(97,145,253,0.33);
    border-top-right-radius:26px;
    border-bottom-right-radius:26px;
    margin: 0px 0px;
    display: flex;
    padding:100px 0px;
    box-shadow:0 20px 50px rgba(43,49,120,0.18);    
  }

  .page-card{
    border-radius:16px;
    width: 70%;
    margin: 0 auto;
    padding:100px 0px 28px;
  }

  .page-heading{
    text-align:center;
    font-size:36px;
    font-weight:700;
    letter-spacing:0.03em;
    margin:0 0 8px;
  }
  
  .page-sub{
    text-align:center;
    font-size:15px;
    color:#475467;
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
  font-size: 18px;
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
  box-shadow:0 5px 3px rgba(43,49,120,0.18);
  border-radius: 12px;
  outline: none;
  transition: border-color 0.15s ease, box-shadow 0.15s ease;
}

.field input::placeholder {
  color: rgba(22,22,22,0.50);
}

.field input:focus {
  border-color: rgba(22,22,22,0.50);
  box-shadow: 0 0 0 4px rgba(53, 56, 205, 0.14);
}

  .send-btn{
    width:100%;
    margin-top:6px;
    padding:13px;
    border:none;
    border-radius:999px;
    background:white;
    color: black;
    font-size:15px;
    cursor:pointer;
  }

  .below-btn{
    display:flex;
    justify-content:center;
    margin-top:16px;
  }

  .back-login{
    font-size:13px;
    font-weight:300;
    color:black;
    text-decoration:none;
  }
  .back-login:hover{color:#3538CD; text-decoration:underline;}
</style>

</head>
<body>

<div class="topbar">
  <span class="topbar-brand">Syedn Tech Solution</span>
</div>

<div class="stage">
  <div class="frame">
    <div class="page-card">
      <h1 class="page-heading">Forgot Password?</h1>
      <p class="page-sub">Enter your e-mail address so we can send you password reset link</p>

       {{-- Display  message when reset link is generated --}}
      @if (session('status'))
        <p id = "status-message" style = "color:green; text-align:center; font-size:13px; margin-bottom:16px;">
          
          {{ session('status') }}
        </p>
      @endif

      {{-- Display email validation error or reset-link error --}}
      @error('email')
        <p id = "email-error" style = "color:red; text-align:center; font-size:13px; margin-bottom:16px;">
          
          {{ $message }}
        </p>
      @enderror

      <form id = "forgot-password-form" method = "POST" action = "{{ route('password.email') }}">
        @csrf

        <div class="field">
          <label for="email">Email</label>
            <input id = "email" name = "email" type = "email" value = "{{ old('email') }}" placeholder = "Enter your email address" required>
        </div>

        <button id = "send-button" class = "send-btn" type = "submit">Send Email</button>

        <div class = "below-btn">
          <a class = "back-login" href = "{{ route('login') }}">&lt; Back to Login</a>
        </div>
      </form>

      {{-- <x-alert>warning</x-alert> --}}

    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('forgot-password-form');
    const button = document.getElementById('send-button');
    const emailInput = document.getElementById('email');

    // Remove spaces around the entered email.
    emailInput.addEventListener('change', function () {
      this.value = this.value.trim();
    });

    // Prevent multiple reset-link requests from one click.
    form.addEventListener('submit', function () {
      emailInput.value = emailInput.value.trim();

      button.disabled = true;
      button.textContent = 'Sending...';
    });

    const statusMessage = document.getElementById('status-message');
    const errorMessage = document.getElementById('email-error');

    if (statusMessage) {
      setTimeout(function () {
        statusMessage.remove();
      }, 7000);
    }

    if (errorMessage) {
      setTimeout(function () {
        errorMessage.remove();
      }, 5000);
    }
  });
</script>

</body>
</html>