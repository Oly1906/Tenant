@extends('layouts.admin')
@section('title','Utilities')
@section('content')

<div class="page-header">
  <h2>Utility Records</h2>
  <a href="{{ route('admin.utilities.create') }}" class="btn btn-primary">+ Add Record</a>
</div>

<div class="card">
  <table>
    <thead>
      <tr>
        <th>Tenant</th>
        <th>Room</th>
        <th>Month</th>
        <th>Electricity</th>
        <th>Water</th>
        <th>Total</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($records as $r)
      <tr>
        <td style="font-weight:600;">{{ $r->tenant->user->name }}</td>
        <td>{{ $r->tenant->room->number }}</td>
        <td>{{ $r->month->format('d M Y') }}</td>
        <td>{{ $r->electricity_kwh }} kWh — ${{ number_format($r->electricity_cost,2) }}</td>
        <td>{{ $r->water_m3 }} m³ — ${{ number_format($r->water_cost,2) }}</td>
        <td style="font-weight:700;">${{ number_format($r->total_cost,2) }}</td>
        <td>
          <div style="display:flex;gap:6px;">
            <a href="{{ route('admin.utilities.edit',$r) }}"
               class="btn btn-sm"
               style="background:#f5f3ff;color:#7c3aed;">
              Edit
            </a>
            <form method="POST"
                  action="{{ route('admin.utilities.destroy',$r) }}"
                  onsubmit="return confirm('Delete record?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger">Delete</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7"
            style="text-align:center;color:var(--muted);padding:30px 0;">
          No utility records found.
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
  <div style="margin-top:16px;">{{ $records->links() }}</div>
</div>
@endsection