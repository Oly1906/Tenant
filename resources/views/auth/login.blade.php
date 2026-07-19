<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — Tenant App</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
  *{margin:0;padding:0;box-sizing:border-box;}
  body{font-family:'Inter',sans-serif;background:#f0f4ff;display:flex;align-items:center;justify-content:center;min-height:100vh;}
  .card{background:white;border-radius:18px;padding:40px;width:100%;max-width:400px;box-shadow:0 4px 24px rgba(59,91,252,.10);}
  .logo{display:flex;align-items:center;gap:12px;margin-bottom:28px;}
  .logo-icon{width:42px;height:42px;background:#3b5bfc;border-radius:12px;display:flex;align-items:center;justify-content:center;}
  .logo-icon svg{width:22px;height:22px;fill:white;}
  .logo-name{font-size:18px;font-weight:700;color:#1a1f3c;}
  h2{font-size:22px;font-weight:700;color:#1a1f3c;margin-bottom:6px;}
  p{color:#6b7280;font-size:13px;margin-bottom:24px;}
  label{display:block;font-size:13px;font-weight:600;color:#1a1f3c;margin-bottom:6px;}
  input[type=email],input[type=password]{width:100%;padding:11px 14px;border:1.5px solid #e5e9f5;border-radius:10px;font-size:14px;font-family:inherit;outline:none;transition:border .15s;}
  input:focus{border-color:#3b5bfc;}
  .form-group{margin-bottom:18px;}
  .btn{width:100%;padding:13px;background:#3b5bfc;color:white;border:none;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit;transition:background .15s;margin-top:6px;}
  .btn:hover{background:#2d4ae0;}
  .error{background:#fee2e2;color:#b91c1c;border-radius:8px;padding:10px 14px;font-size:13px;margin-bottom:16px;}
</style>
</head>
<body>
<div class="card">
  <div class="logo">
    <div class="logo-icon"><svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg></div>
    <div class="logo-name">TENANT APP</div>
  </div>
  <h2>Welcome back</h2>
  <p>Sign in to your account to continue</p>

  @if($errors->any())
    <div class="error">{{ $errors->first() }}</div>
  @endif
  @if(session('error'))
    <div class="error">{{ session('error') }}</div>
  @endif

  <form method="POST" action="/login">
    @csrf
    <div class="form-group">
      <label>Email address</label>
      <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required autofocus>
    </div>
    <div class="form-group">
      <label>Password</label>
      <input type="password" name="password" placeholder="••••••••" required>
    </div>
    <button class="btn" type="submit">Sign In</button>
  </form>
</div>
</body>
</html>