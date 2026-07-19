@extends('layouts.tenant')
@section('title','Profile & Settings')
@section('content')
<div class="card">
  <div style="display:flex;align-items:center;gap:18px;margin-bottom:20px;">
    <div style="width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,#3b5bfc,#8b5cf6);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:22px;">
      {{ strtoupper(substr($user->name,0,2)) }}
    </div>
    <div>
      <div style="font-size:20px;font-weight:800;">{{ $user->name }}</div>
      <div style="color:var(--muted);font-size:13px;">Tenant · Room {{ $tenant?->room?->number }}</div>
    </div>
  </div>
  <form method="POST" action="{{ route('tenant.profile.update') }}">
    @csrf @method('PUT')
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
      <div class="form-group" style="margin-bottom:0;">
        <label style="display:block;font-size:13px;font-weight:600;margin-bottom:6px;">Full Name</label>
        <input name="name" class="form-control" value="{{ $user->name }}" required style="width:100%;padding:10px 13px;border:1.5px solid var(--border);border-radius:10px;font-size:13.5px;font-family:inherit;outline:none;">
      </div>
      <div class="form-group" style="margin-bottom:0;">
        <label style="display:block;font-size:13px;font-weight:600;margin-bottom:6px;">Email</label>
        <input value="{{ $user->email }}" disabled style="width:100%;padding:10px 13px;border:1.5px solid var(--border);border-radius:10px;font-size:13.5px;background:#f9fafb;color:var(--muted);">
      </div>
      <div class="form-group" style="margin-bottom:0;">
        <label style="display:block;font-size:13px;font-weight:600;margin-bottom:6px;">Phone</label>
        <input name="phone" class="form-control" value="{{ $user->phone }}" style="width:100%;padding:10px 13px;border:1.5px solid var(--border);border-radius:10px;font-size:13.5px;font-family:inherit;outline:none;">
      </div>
      <div class="form-group" style="margin-bottom:0;">
        <label style="display:block;font-size:13px;font-weight:600;margin-bottom:6px;">Emergency Contact</label>
        <input name="emergency_contact" class="form-control" value="{{ $user->emergency_contact }}" style="width:100%;padding:10px 13px;border:1.5px solid var(--border);border-radius:10px;font-size:13.5px;font-family:inherit;outline:none;">
      </div>
      <div class="form-group" style="margin-bottom:0;">
        <label style="display:block;font-size:13px;font-weight:600;margin-bottom:6px;">New Password (optional)</label>
        <input name="password" type="password" class="form-control" style="width:100%;padding:10px 13px;border:1.5px solid var(--border);border-radius:10px;font-size:13.5px;font-family:inherit;outline:none;">
      </div>
      <div class="form-group" style="margin-bottom:0;">
        <label style="display:block;font-size:13px;font-weight:600;margin-bottom:6px;">Confirm Password</label>
        <input name="password_confirmation" type="password" class="form-control" style="width:100%;padding:10px 13px;border:1.5px solid var(--border);border-radius:10px;font-size:13.5px;font-family:inherit;outline:none;">
      </div>
    </div>
    <div style="margin-top:20px;display:flex;gap:12px;">
      <button type="submit" class="btn btn-primary">Save Changes</button>
    </div>
  </form>
</div>

<div class="card">
  <div class="card-title">Lease Info</div>
  <div class="detail-row"><span class="detail-label">Room</span><span class="detail-value">{{ $tenant?->room?->number }} — {{ $tenant?->room?->type }}</span></div>
  <div class="detail-row"><span class="detail-label">Lease Start</span><span class="detail-value">{{ $tenant?->lease_start?->format('d M Y') }}</span></div>
  <div class="detail-row"><span class="detail-label">Lease End</span><span class="detail-value">{{ $tenant?->lease_end?->format('d M Y') }}</span></div>
  <div class="detail-row"><span class="detail-label">Monthly Rent</span><span class="detail-value">${{ number_format($tenant?->room?->price ?? 0,2) }}</span></div>
  <div class="detail-row"><span class="detail-label">Deposit Paid</span><span class="detail-value">${{ number_format($tenant?->deposit ?? 0,2) }}</span></div>
</div>
@endsection