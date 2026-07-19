<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tenant App — @yield('title','Dashboard')</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
  :root{--bg:#f0f4ff;--sidebar:#1a1f3c;--sidebar-hover:#252b4a;--sidebar-active:#3b5bfc;--card:#fff;--text:#1a1f3c;--muted:#6b7280;--border:#e5e9f5;--blue:#3b5bfc;--green:#22c55e;--orange:#f59e0b;--red:#ef4444;--shadow:0 2px 12px rgba(59,91,252,.08);}
  *{margin:0;padding:0;box-sizing:border-box;}
  body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);display:flex;height:100vh;overflow:hidden;}
  .sidebar{width:220px;min-width:220px;background:var(--sidebar);display:flex;flex-direction:column;overflow-y:auto;}
  .sidebar-logo{padding:22px 20px 18px;border-bottom:1px solid rgba(255,255,255,.07);}
  .logo-row{display:flex;align-items:center;gap:10px;}
  .logo-icon{width:34px;height:34px;background:var(--blue);border-radius:10px;display:flex;align-items:center;justify-content:center;}
  .logo-icon svg{width:18px;height:18px;fill:white;}
  .logo-name{color:white;font-weight:700;font-size:15px;}
  .logo-sub{color:rgba(255,255,255,.4);font-size:11px;margin-top:2px;}
  .sidebar-nav{padding:16px 0;flex:1;}
  .nav-item{display:flex;align-items:center;gap:12px;padding:11px 20px;color:rgba(255,255,255,.55);font-size:13.5px;cursor:pointer;transition:all .18s;text-decoration:none;border-left:3px solid transparent;}
  .nav-item:hover{background:var(--sidebar-hover);color:rgba(255,255,255,.9);}
  .nav-item.active{background:rgba(59,91,252,.18);color:white;border-left-color:var(--blue);font-weight:600;}
  .nav-item svg{width:17px;height:17px;opacity:.8;flex-shrink:0;}
  .nav-item.active svg{opacity:1;}
  .sidebar-profile{padding:14px 16px;border-top:1px solid rgba(255,255,255,.07);display:flex;align-items:center;gap:10px;}
  .avatar{width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#3b5bfc,#8b5cf6);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:13px;flex-shrink:0;}
  .profile-name{color:white;font-size:13px;font-weight:600;}
  .profile-role{color:rgba(255,255,255,.4);font-size:11px;}
  .main{flex:1;overflow-y:auto;display:flex;flex-direction:column;}
  .topbar{background:white;padding:16px 28px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid var(--border);position:sticky;top:0;z-index:50;}
  .topbar-title{font-size:18px;font-weight:700;}
  .content{padding:24px 28px;flex:1;}
  .card{background:var(--card);border-radius:14px;box-shadow:var(--shadow);padding:20px;margin-bottom:18px;}
  .card-title{font-size:13px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:14px;}
  .badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;}
  .badge-green{background:#dcfce7;color:#15803d;}
  .badge-orange{background:#fef3c7;color:#b45309;}
  .badge-red{background:#fee2e2;color:#b91c1c;}
  .badge-blue{background:#eff6ff;color:#1d4ed8;}
  table{width:100%;border-collapse:collapse;}
  th{text-align:left;font-size:11.5px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;padding:0 0 10px;border-bottom:1px solid var(--border);}
  td{padding:12px 0;border-bottom:1px solid var(--border);font-size:13.5px;}
  tr:last-child td{border-bottom:none;}
  .detail-row{display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border);font-size:13.5px;}
  .detail-row:last-child{border-bottom:none;}
  .detail-label{color:var(--muted);}
  .detail-value{font-weight:600;}
  .btn{display:inline-flex;align-items:center;gap:7px;padding:10px 18px;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;border:none;font-family:inherit;transition:all .15s;text-decoration:none;}
  .btn-primary{background:var(--blue);color:white;}
  .btn-primary:hover{background:#2d4ae0;}
  .btn-outline{background:white;color:var(--blue);border:1.5px solid var(--blue);}
  .alert-success{background:#dcfce7;color:#15803d;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-size:13px;}
</style>
</head>
<body>
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-row">
      <div class="logo-icon"><svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div>
      <div><div class="logo-name">TENANT APP</div><div class="logo-sub">Modern tenant portal</div></div>
    </div>
  </div>
  <nav class="sidebar-nav">
    <a class="nav-item {{ request()->routeIs('tenant.dashboard') ? 'active' : '' }}" href="{{ route('tenant.dashboard') }}">
      <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg> Dashboard
    </a>
    <a class="nav-item {{ request()->routeIs('tenant.invoices.*') ? 'active' : '' }}" href="{{ route('tenant.invoices.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg> Invoices
    </a>
    <a class="nav-item {{ request()->routeIs('tenant.utilities.*') ? 'active' : '' }}" href="{{ route('tenant.utilities.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg> Utilities
    </a>
    <a class="nav-item {{ request()->routeIs('tenant.contracts.*') ? 'active' : '' }}" href="{{ route('tenant.contracts.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg> Contract
    </a>
    <a class="nav-item {{ request()->routeIs('tenant.announcements.*') ? 'active' : '' }}" href="{{ route('tenant.announcements.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 17H2a3 3 0 000 6h20M18 12V6a6 6 0 00-12 0v6"/></svg> Announcements
    </a>
    <a class="nav-item {{ request()->routeIs('tenant.profile') ? 'active' : '' }}" href="{{ route('tenant.profile') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> Profile
    </a>
  </nav>
  <div class="sidebar-profile">
    <div class="avatar">{{ strtoupper(substr(auth()->user()->name,0,2)) }}</div>
    <div>
      <div class="profile-name">{{ auth()->user()->name }}</div>
      <div class="profile-role">Tenant · Room {{ auth()->user()->tenant?->room?->number }}</div>
    </div>
  </div>
</aside>

<main class="main">
  <div class="topbar">
    <div class="topbar-title">@yield('title','Dashboard')</div>
    <div style="display:flex;align-items:center;gap:12px;">
      <div class="avatar" style="width:34px;height:34px;font-size:13px;">{{ strtoupper(substr(auth()->user()->name,0,2)) }}</div>
      <form method="POST" action="/logout">@csrf
        <button style="background:none;border:none;cursor:pointer;color:var(--muted);font-size:13px;">Sign out</button>
      </form>
    </div>
  </div>
  <div class="content">
    @if(session('success'))
      <div class="alert-success">{{ session('success') }}</div>
    @endif
    @yield('content')
  </div>
</main>
</body>
</html>