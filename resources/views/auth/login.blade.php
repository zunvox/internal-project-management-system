<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign In — Syedn Tech Solution</title>
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
    height: 800px;
  }

  /* Top bar */
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
    flex:1;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:48px 24px;
    background-image: url(https://img.magnific.com/free-photo/vivid-blurred-colorful-wallpaper-background_58702-3883.jpg?semt=ais_test_b&w=740&q=80);
    background-repeat:no-repeat;
    background-size: cover;
    background-position: center;
  }

  .frame{
    width:100%;
    max-width:680px;
    background:rgba(97,145,253,0.33);
    border-radius:26px;
    padding:62px 0px 60px;
    box-shadow:0 20px 50px rgba(43,49,120,0.18);
  }

  /* Login card */
  .login-card{
    background:white;
    border-radius:16px;
    width: 75%;
    margin: 0 auto;
    box-shadow:0 1px 2px rgba(16,24,40,0.06), 0 8px 24px rgba(16,24,40,0.08);
    padding:36px 32px 28px;
  }

  .login-heading{
    text-align:center;
    font-size:40px;
    font-weight:700;
    letter-spacing:0.03em;
    margin:0 0 8px;
  }
  .login-sub{
    text-align:center;
    font-size:20px;
    color:black;
    margin:0 0 28px;
  }

  .field {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin-bottom: 20px;
}

.field label {
  font-size: 14px;
  font-weight: 700;
  color: #101828;
}

.field input {
  width: 100%;
  padding: 12px 16px; 
  font-size: 13px;
  font-family: 'Inter',system-ui,sans-serif;
  color: black;
  background-color: #ffffff;
  border: 1px solid rgba(22,22,22,0.50);
  box-shadow:0 5px 3px rgba(43,49,120,0.18);    
  border-radius: 12px;
  outline: none;
  transition: border-color 0.15s ease, box-shadow 0.15s ease;
}

.field input::placeholder {
  color: #98A2B3;
}

.field input:focus {
  border-color: #3538CD;
  box-shadow: 0 0 0 4px rgba(53, 56, 205, 0.14);
}

  .signin-btn{
    width:100%;
    margin-top:6px;
    padding:13px;
    border:none;
    border-radius:999px;
    background:  rgba(43,111,255,0.80);
    color: white;
    font-size:15px;
    cursor:pointer;
    box-shadow:0 4px 14px rgba(53,56,205,0.35);
  }

  .below-btn{
    display:flex;
    justify-content:center;
    margin-top:16px;
  }
  .forgot-link{
    font-size:13px;
    font-weight:500;
    color:#475467;
    text-decoration:none;
  }
  .forgot-link:hover{color:#3538CD; text-decoration:underline;}
</style>

</head>
<body>

<div class="topbar">
  <span class="topbar-brand">Syedn Tech Solution</span>
</div>

<div class="stage">
  <div class="frame">
    <div class="login-card">
      <h1 class="login-heading">WELCOME</h1>
      <p class="login-sub">Login to get started</p>

      @if (session('status'))
      <p id = "status-message" style = "color:green; text-align:center; font-size:13px; margin-bottom:16px;">

        {{ session('status') }}

      </p>
      @endif

      @if ($errors->has('email'))
        <p id="login-error" style="color:red; text-align:center; font-size:13px; margin-bottom:16px;">
    
          {{ $errors->first('email') }}
        </p>
      @endif

      <form id = "login-form" method = "POST" action="{{ route('login.store') }}">
        @csrf

        <div class="field">
          <label for = "email">Email</label>
            <input id = "email" name = "email" type = "email" value = "{{ old('email') }}" placeholder = "e.g syed@syedn.xyz" required>
        </div>

        <div class="field">
          <label for = "password">Password</label>
            <input id = "password" name = "password" type = "password" placeholder = "e.g hello123" required>
        </div>

        <button id = "signin-button" class="signin-btn" type="submit">Sign In</button>

        <div class = "below-btn">
          <a class = "forgot-link" href = "{{  route('password.request') }}">Forgot Password?</a>
        </div>
      </form>

    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('login-form');
    const button = document.getElementById('signin-button');
    const emailInput = document.getElementById('email');

    // Remove additional accidental spaces in the submitted email
    emailInput.addEventListener('change', function () {
      this.value = this.value.trim();
    });

    // Prevent same email being submitted multiple times
    form.addEventListener('submit', function () {
      emailInput.value = emailInput.value.trim();

      button.disabled = true;
      button.textContent = 'Signing In...';
    });

    // Automatically remove messages after a few seconds.
    const statusMessage = document.getElementById('status-message');
    const errorMessage = document.getElementById('login-error');

    if (statusMessage) {
      setTimeout(function () {
        statusMessage.remove();
      }, 5000);
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