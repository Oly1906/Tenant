@extends('layouts.admin')
@section('title','Tenants')
@section('content')

<div class="page-header">
  <h2>Active Tenants</h2>
  <a href="{{ route('admin.tenants.create') }}" class="btn btn-primary">+ Add Tenant</a>
</div>

<div class="card">
  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Room</th>
        <th>Lease Start</th>
        <th>Lease End</th>
        <th>Deposit</th>
        <th>Status</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @forelse($tenants as $t)
      <tr>
        <td style="font-weight:600;">{{ $t->user->name }}</td>
        <td>{{ $t->user->email }}</td>
        <td>{{ $t->room->number }} ({{ $t->room->property->name }})</td>
        <td>{{ $t->lease_start->format('d M Y') }}</td>
        <td>{{ $t->lease_end->format('d M Y') }}</td>
        <td>${{ number_format($t->deposit,2) }}</td>
        <td>
          <span class="badge {{ $t->status==='active' ? 'badge-green' : 'badge-red' }}">
            {{ ucfirst($t->status) }}
          </span>
        </td>
        <td style="display:flex;gap:6px;">
          <a href="{{ route('admin.tenants.show',$t) }}"
             class="btn btn-sm"
             style="background:#eff6ff;color:var(--blue);">View</a>
          <a href="{{ route('admin.tenants.edit',$t) }}"
             class="btn btn-sm"
             style="background:#f5f3ff;color:#7c3aed;">Edit</a>
          <form method="POST"
                action="{{ route('admin.tenants.destroy',$t) }}"
                onsubmit="return confirm('Deactivate this tenant?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">End Lease</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="8" style="text-align:center;color:var(--muted);padding:30px 0;">
          No active tenants found.
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <div style="margin-top:16px;">
    {{ $tenants->links() }}
  </div>
</div>

@endsection