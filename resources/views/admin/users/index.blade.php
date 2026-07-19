@extends('layouts.admin')
@section('title','Users')
@section('content')
<div class="page-header">
  <h2>All Users</h2>
  <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Add User</a>
</div>
<div class="card">
  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Role</th>
        <th>Joined</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $user)
      <tr>
        <td style="font-weight:600;">{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->phone ?? '–' }}</td>
        <td>
          <span class="badge {{ $user->role==='admin' ? 'badge-blue' : 'badge-green' }}">
            {{ ucfirst($user->role) }}
          </span>
        </td>
        <td>{{ $user->created_at->format('d M Y') }}</td>
        <td style="display:flex;gap:6px;">
          <a href="{{ route('admin.users.edit',$user) }}"
             class="btn btn-sm" style="background:#f5f3ff;color:#7c3aed;">Edit</a>
          @if($user->id !== auth()->id())
          <form method="POST" action="{{ route('admin.users.destroy',$user) }}"
                onsubmit="return confirm('Delete user?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Delete</button>
          </form>
          @endif
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6" style="text-align:center;color:var(--muted);padding:30px 0;">
          No users found.
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
  <div style="margin-top:16px;">{{ $users->links() }}</div>
</div>
@endsection
