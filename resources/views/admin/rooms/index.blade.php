@extends('layouts.admin')
@section('title','Rooms')
@section('content')
<div class="page-header">
  <h2>All Rooms</h2>
  <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">+ Add Room</a>
</div>
<div class="card">
  <table>
    <thead><tr><th>Number</th><th>Type</th><th>Floor</th><th>Size</th><th>Price</th><th>Tenant</th><th>Status</th><th></th></tr></thead>
    <tbody>
      @foreach($rooms as $room)
      <tr>
        <td style="font-weight:700;">{{ $room->number }}</td>
        <td>{{ $room->type }}</td>
        <td>{{ $room->floor }}</td>
        <td>{{ $room->size }} m²</td>
        <td>${{ number_format($room->price,2) }}/mo</td>
        <td>{{ $room->tenant?->user?->name ?? '–' }}</td>
        <td><span class="badge {{ $room->status==='occupied' ? 'badge-blue' : 'badge-green' }}">{{ ucfirst($room->status) }}</span></td>
        <td>
          <a href="{{ route('admin.rooms.edit',$room) }}" class="btn btn-sm" style="background:#eff6ff;color:var(--blue);">Edit</a>
          <form method="POST" action="{{ route('admin.rooms.destroy',$room) }}" style="display:inline;" onsubmit="return confirm('Delete?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Del</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div style="margin-top:16px;">{{ $rooms->links() }}</div>
</div>
@endsection