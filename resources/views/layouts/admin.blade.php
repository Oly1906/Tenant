<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin — @yield('title','Dashboard')</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
  :root{--bg:#f1f4fc;--sidebar:#0f1629;--sidebar-hover:#1a2240;--card:#fff;--text:#0f1629;--muted:#64748b;--border:#e2e8f5;--blue:#3b5bfc;--green:#22c55e;--orange:#f59e0b;--red:#ef4444;--shadow:0 2px 14px rgba(15,22,41,.08);}
  *{margin:0;padding:0;box-sizing:border-box;}
  body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);display:flex;height:100vh;overflow:hidden;}
  .sidebar{width:220px;min-width:220px;background:var(--sidebar);display:flex;flex-direction:column;overflow-y:auto;}
  .sidebar-logo{padding:22px 18px 18px;border-bottom:1px solid rgba(255,255,255,.06);}
  .logo-row{display:flex;align-items:center;gap:10px;}
  .logo-icon{width:36px;height:36px;background:var(--blue);border-radius:10px;display:flex;align-items:center;justify-content:center;}
  .logo-icon svg{width:18px;height:18px;fill:white;}
  .logo-name{color:white;font-weight:800;font-size:14px;}
  .logo-sub{color:rgba(255,255,255,.35);font-size:10.5px;margin-top:2px;}
  .sidebar-nav{padding:14px 0;flex:1;}
  .nav-section{padding:16px 18px 6px;font-size:10px;font-weight:700;color:rgba(255,255,255,.25);letter-spacing:1px;text-transform:uppercase;}
  .nav-item{display:flex;align-items:center;gap:11px;padding:10px 18px;color:rgba(255,255,255,.5);font-size:13px;cursor:pointer;transition:all .15s;border-left:3px solid transparent;text-decoration:none;}
  .nav-item:hover{background:var(--sidebar-hover);color:rgba(255,255,255,.85);}
  .nav-item.active{background:rgba(59,91,252,.15);color:white;border-left-color:var(--blue);font-weight:600;}
  .nav-item svg{width:16px;height:16px;flex-shrink:0;opacity:.7;}
  .nav-item.active svg{opacity:1;}
  .sidebar-profile{padding:14px 16px;border-top:1px solid rgba(255,255,255,.06);display:flex;align-items:center;gap:10px;}
  .avatar{width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#3b5bfc,#8b5cf6);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:12px;flex-shrink:0;}
  .profile-name{color:white;font-size:12.5px;font-weight:600;}
  .profile-role{color:rgba(255,255,255,.35);font-size:10.5px;}
  .main{flex:1;overflow-y:auto;display:flex;flex-direction:column;}
  .topbar{background:white;padding:14px 26px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid var(--border);position:sticky;top:0;z-index:50;}
  .topbar-left h1{font-size:17px;font-weight:800;}
  .topbar-left p{font-size:12px;color:var(--muted);margin-top:1px;}
  .topbar-right{display:flex;align-items:center;gap:12px;}
  .content{padding:22px 26px;flex:1;}
  .card{background:white;border-radius:14px;box-shadow:var(--shadow);padding:20px;margin-bottom:18px;}
  .card-title{font-size:14px;font-weight:700;margin-bottom:14px;}
  .btn{display:inline-flex;align-items:center;gap:6px;padding:9px 16px;border-radius:10px;font-size:12.5px;font-weight:600;cursor:pointer;border:none;font-family:inherit;transition:all .15s;text-decoration:none;}
  .btn-primary{background:var(--blue);color:white;}
  .btn-primary:hover{background:#2d4ae0;}
  .btn-danger{background:#fee2e2;color:#b91c1c;}
  .btn-sm{padding:6px 12px;font-size:12px;}
  table{width:100%;border-collapse:collapse;}
  th{text-align:left;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;padding:0 0 10px;border-bottom:1px solid var(--border);}
  td{padding:11px 0;border-bottom:1px solid var(--border);font-size:13px;}
  tr:last-child td{border-bottom:none;}
  .badge{display:inline-flex;align-items:center;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:600;}
  .badge-green{background:#dcfce7;color:#15803d;}
  .badge-orange{background:#fef3c7;color:#b45309;}
  .badge-red{background:#fee2e2;color:#b91c1c;}
  .badge-blue{background:#eff6ff;color:#1d4ed8;}
  .form-group{margin-bottom:16px;}
  .form-group label{display:block;font-size:13px;font-weight:600;margin-bottom:6px;}
  .form-control{width:100%;padding:10px 13px;border:1.5px solid var(--border);border-radius:10px;font-size:13.5px;font-family:inherit;outline:none;}
  .form-control:focus{border-color:var(--blue);}
  .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;}
  .page-header h2{font-size:16px;font-weight:800;}
  .alert-success{background:#dcfce7;color:#15803d;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-size:13px;}
  .kpi-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:14px;margin-bottom:18px;}
  .kpi-card{background:white;border-radius:14px;padding:18px;box-shadow:var(--shadow);}
  .kpi-label{font-size:12px;color:var(--muted);}
  .kpi-value{font-size:26px;font-weight:800;margin-top:10px;}
  .kpi-meta{font-size:11.5px;color:var(--muted);margin-top:4px;}
</style>
</head>
<body>

<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-row">
      <div class="logo-icon">
        <svg viewBox="0 0 24 24">
          <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
        </svg>
      </div>
        <div class="logo-name">
          ADMIN PANEL
        </div>
    </div>
  </div>s
  <nav class="sidebar-nav">
    <div class="nav-section">Main</div>
    <a class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg> Dashboard
    </a>
    <a class="nav-item {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}" href="{{ route('admin.rooms.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg> Rooms
    </a>
    <a class="nav-item {{ request()->routeIs('admin.tenants.*') ? 'active' : '' }}" href="{{ route('admin.tenants.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg> Tenants
    </a>
    <div class="nav-section">Finance</div>
    <a class="nav-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}" href="{{ route('admin.payments.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg> Payments
    </a>
    <a class="nav-item {{ request()->routeIs('admin.invoices.*') ? 'active' : '' }}" href="{{ route('admin.invoices.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg> Invoices
    </a>
    <a class="nav-item {{ request()->routeIs('admin.utilities.*') ? 'active' : '' }}" href="{{ route('admin.utilities.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg> Utilities
    </a>
    <div class="nav-section">Operations</div>
    <a class="nav-item {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}" href="{{ route('admin.announcements.index') }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 17H2a3 3 0 000 6h20M18 12V6a6 6 0 00-12 0v6"/></svg> Announcements
    </a>
    <a class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
        href="{{ route('admin.users.index') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
        </svg> Users
        </a>
  </nav>
  <div class="sidebar-profile">
    <div class="avatar">{{ strtoupper(substr(auth()->user()->name,0,2)) }}</div>
    <div>
      <div class="profile-name">{{ auth()->user()->name }}</div>
      <div class="profile-role">{{ auth()->user()->email }}</div>
    </div>
  </div>
</aside>

<main class="main">
  <div class="topbar">
    <div class="topbar-left">
      <h1>@yield('title','Dashboard')</h1>
      <p>@yield('subtitle','')</p>
    </div>
    <div class="topbar-right">
      <form method="POST" action="/logout">@csrf
        <button class="btn" style="background:#fee2e2;color:#b91c1c;" type="submit">Sign Out</button>
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