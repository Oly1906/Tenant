@extends('layouts.admin')
@section('title','Dashboard')
@section('subtitle','Overview of your property')

@section('content')
<div class="kpi-grid">
  <div class="kpi-card">
    <div class="kpi-label">Total Rooms</div>
    <div class="kpi-value">{{ $totalRooms }}</div>
    <div class="kpi-meta"><a href="{{ route('admin.rooms.index') }}" style="color:var(--blue);">View all →</a></div>
  </div>
  <div class="kpi-card">
    <div class="kpi-label">Occupied</div>
    <div class="kpi-value">{{ $occupiedRooms }}</div>
    <div class="kpi-meta" style="color:var(--green);">{{ $totalRooms ? round($occupiedRooms/$totalRooms*100,1) : 0 }}% Occupancy</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-label">Available</div>
    <div class="kpi-value">{{ $availableRooms }}</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-label">Monthly Income</div>
    <div class="kpi-value" style="font-size:22px;">${{ number_format($monthlyIncome,2) }}</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-label">Outstanding</div>
    <div class="kpi-value" style="font-size:22px;color:var(--red);">${{ number_format($outstanding,2) }}</div>
    <div class="kpi-meta"><a href="{{ route('admin.payments.index') }}" style="color:var(--blue);">View details →</a></div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">
  <div class="card">
    <div class="card-title">Recent Tenants</div>
    <table>
      <thead><tr><th>Name</th><th>Room</th><th>Lease End</th></tr></thead>
      <tbody>
        @foreach($recentTenants as $t)
        <tr>
          <td>{{ $t->user->name }}</td>
          <td>{{ $t->room->number }}</td>
          <td>{{ $t->lease_end->format('d M Y') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="card">
    <div class="card-title">Recent Invoices</div>
    <table>
      <thead><tr><th>Invoice</th><th>Tenant</th><th>Total</th><th>Status</th></tr></thead>
      <tbody>
        @foreach($recentInvoices as $inv)
        <tr>
          <td style="font-weight:700;">{{ $inv->invoice_number }}</td>
          <td>{{ $inv->tenant->user->name }}</td>
          <td>${{ number_format($inv->total,2) }}</td>
          <td><span class="badge {{ $inv->status==='paid' ? 'badge-green' : 'badge-orange' }}">{{ ucfirst($inv->status) }}</span></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="card">
  <div class="card-title">Recent Announcements</div>
  @foreach($announcements as $ann)
  <div style="padding:12px 0;border-bottom:1px solid var(--border);">
    <div style="font-weight:700;font-size:13px;">{{ $ann->title }}</div>
    <div style="color:var(--muted);font-size:12px;margin-top:4px;">{{ $ann->body }}</div>
    <div style="color:var(--muted);font-size:11px;margin-top:4px;">{{ $ann->created_at->diffForHumans() }}</div>
  </div>
  @endforeach
</div>
@endsection