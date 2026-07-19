@extends('layouts.admin')
@section('title','Add Tenant')
@section('content')
<div class="page-header"><h2>Add Tenant</h2><a href="{{ route('admin.tenants.index') }}" class="btn">← Back</a></div>
<div class="card" style="max-width:620px;">
  <form method="POST" action="{{ route('admin.tenants.store') }}">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
      <div class="form-group"><label>Full Name</label><input name="name" class="form-control" required value="{{ old('name') }}"></div>
      <div class="form-group"><label>Email</label><input name="email" type="email" class="form-control" required value="{{ old('email') }}"></div>
      <div class="form-group"><label>Password</label><input name="password" type="password" class="form-control" required></div>
      <div class="form-group"><label>Phone</label><input name="phone" class="form-control" value="{{ old('phone') }}"></div>
      <div class="form-group">
        <label>Room</label>
        <select name="room_id" class="form-control" required>
          <option value="">Select room…</option>
          @foreach($rooms as $r)<option value="{{ $r->id }}">{{ $r->number }} — ${{ $r->price }}/mo</option>@endforeach
        </select>
      </div>
      <div class="form-group"><label>Deposit ($)</label><input name="deposit" type="number" step="0.01" class="form-control" value="0"></div>
      <div class="form-group"><label>Lease Start</label><input name="lease_start" type="date" class="form-control" required></div>
      <div class="form-group"><label>Lease End</label><input name="lease_end" type="date" class="form-control" required></div>
    </div>
    @if($errors->any())
      <div style="background:#fee2e2;color:#b91c1c;padding:12px;border-radius:8px;margin-bottom:12px;font-size:13px;">
        @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
      </div>
    @endif
    <button class="btn btn-primary" type="submit">Create Tenant</button>
  </form>
</div>
@endsection