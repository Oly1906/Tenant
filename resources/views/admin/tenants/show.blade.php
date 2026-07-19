@extends('layouts.admin')
@section('title','Tenant Details')
@section('content')
<div class="page-header">
  <h2>{{ $tenant->user->name }}</h2>
  <div style="display:flex;gap:10px;">
    <a href="{{ route('admin.tenants.edit',$tenant) }}" class="btn btn-primary">Edit</a>
    <a href="{{ route('admin.tenants.index') }}" class="btn">← Back</a>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">
  <div class="card">
    <div class="card-title">Personal Info</div>
    <div class="detail-row"><span class="detail-label">Name</span><span class="detail-value">{{ $tenant->user->name }}</span></div>
    <div class="detail-row"><span class="detail-label">Email</span><span class="detail-value">{{ $tenant->user->email }}</span></div>
    <div class="detail-row"><span class="detail-label">Phone</span><span class="detail-value">{{ $tenant->user->phone ?? '–' }}</span></div>
  </div>
  <div class="card">
    <div class="card-title">Lease Details</div>
    <div class="detail-row"><span class="detail-label">Room</span><span class="detail-value">{{ $tenant->room->number }}</span></div>
    <div class="detail-row"><span class="detail-label">Property</span><span class="detail-value">{{ $tenant->room->property->name }}</span></div>
    <div class="detail-row"><span class="detail-label">Lease Start</span><span class="detail-value">{{ $tenant->lease_start->format('d M Y') }}</span></div>
    <div class="detail-row"><span class="detail-label">Lease End</span><span class="detail-value">{{ $tenant->lease_end->format('d M Y') }}</span></div>
    <div class="detail-row"><span class="detail-label">Monthly Rent</span><span class="detail-value">${{ number_format($tenant->room->price,2) }}</span></div>
    <div class="detail-row"><span class="detail-label">Deposit</span><span class="detail-value">${{ number_format($tenant->deposit,2) }}</span></div>
  </div>
</div>

<div class="card">
  <div class="card-title">Invoices</div>
  <table>
    <thead><tr><th>Invoice #</th><th>Month</th><th>Total</th><th>Status</th><th></th></tr></thead>
    <tbody>
      @foreach($tenant->invoices as $inv)
      <tr>
        <td style="font-weight:700;">{{ $inv->invoice_number }}</td>
        <td>{{ $inv->month->format('M Y') }}</td>
        <td>${{ number_format($inv->total,2) }}</td>
        <td><span class="badge {{ $inv->status==='paid' ? 'badge-green' : 'badge-orange' }}">{{ ucfirst($inv->status) }}</span></td>
        <td><a href="{{ route('admin.invoices.download',$inv) }}" style="color:var(--blue);font-size:12px;font-weight:600;">PDF</a></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="card">
  <div class="card-title">Utility Records</div>
  <table>
    <thead><tr><th>Month</th><th>Electricity</th><th>Water</th><th>Total</th></tr></thead>
    <tbody>
      @foreach($tenant->utilityRecords as $u)
      <tr>
        <td>{{ $u->month->format('M Y') }}</td>
        <td>{{ $u->electricity_kwh }} kWh — ${{ number_format($u->electricity_cost,2) }}</td>
        <td>{{ $u->water_m3 }} m³ — ${{ number_format($u->water_cost,2) }}</td>
        <td style="font-weight:700;">${{ number_format($u->total_cost,2) }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection