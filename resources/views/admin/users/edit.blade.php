@extends('layouts.admin')
@section('title','Edit User')
@section('content')
<div class="page-header">
  <h2>Edit User — {{ $user->name }}</h2>
  <a href="{{ route('admin.users.index') }}" class="btn">← Back</a>
</div>
<div class="card" style="max-width:560px;">
  <form method="POST" action="{{ route('admin.users.update',$user) }}">
    @csrf @method('PUT')
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
      <div class="form-group"><label>Full Name</label>
        <input name="name" class="form-control" required value="{{ $user->name }}">
      </div>
      <div class="form-group"><label>Email</label>
        <input name="email" type="email" class="form-control" required value="{{ $user->email }}">
      </div>
      <div class="form-group"><label>Phone</label>
        <input name="phone" class="form-control" value="{{ $user->phone }}">
      </div>
      <div class="form-group">
        <label>Role</label>
        <select name="role" class="form-control">
          <option value="tenant" {{ $user->role==='tenant' ? 'selected':'' }}>Tenant</option>
          <option value="admin"  {{ $user->role==='admin'  ? 'selected':'' }}>Admin</option>
        </select>
      </div>
      <div class="form-group"><label>New Password (optional)</label>
        <input name="password" type="password" class="form-control">
      </div>
      <div class="form-group"><label>Confirm Password</label>
        <input name="password_confirmation" type="password" class="form-control">
      </div>
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