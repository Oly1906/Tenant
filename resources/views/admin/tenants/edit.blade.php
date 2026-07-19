@extends('layouts.admin')
@section('title','Edit Tenant')
@section('content')
<div class="page-header">
  <h2>Edit Tenant — {{ $tenant->user->name }}</h2>
  <a href="{{ route('admin.tenants.index') }}" class="btn">← Back</a>
</div>
<div class="card" style="max-width:620px;">
  <form method="POST" action="{{ route('admin.tenants.update',$tenant) }}">
    @csrf @method('PUT')
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
      <div class="form-group"><label>Full Name</label><input name="name" class="form-control" value="{{ $tenant->user->name }}" required></div>
      <div class="form-group"><label>Phone</label><input name="phone" class="form-control" value="{{ $tenant->user->phone }}"></div>
      <div class="form-group"><label>Lease Start</label><input name="lease_start" type="date" class="form-control" value="{{ $tenant->lease_start->format('Y-m-d') }}" required></div>
      <div class="form-group"><label>Lease End</label><input name="lease_end" type="date" class="form-control" value="{{ $tenant->lease_end->format('Y-m-d') }}" required></div>
      <div class="form-group"><label>Deposit ($)</label><input name="deposit" type="number" step="0.01" class="form-control" value="{{ $tenant->deposit }}"></div>
    </div>
    @if($errors->any())
      <div style="background:#fee2e2;color:#b91c1c;padding:12px;border-radius:8px;margin-bottom:12px;font-size:13px;">
        @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
      </div>
    @endif
    <button class="btn btn-primary" type="submit">Save Changes</button>
  </form>
</div>
@endsection