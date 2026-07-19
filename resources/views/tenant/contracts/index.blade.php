@extends('layouts.tenant')
@section('title','Contract')
@section('content')
<div class="card">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
    <div style="font-size:15px;font-weight:700;">Active Lease Agreement</div>
    <span class="badge badge-green">Active</span>
  </div>
  <div class="detail-row"><span class="detail-label">Tenant Name</span><span class="detail-value">{{ $tenant->user->name }}</span></div>
  <div class="detail-row"><span class="detail-label">Room</span><span class="detail-value">{{ $tenant->room->number }} — {{ $tenant->room->type }}</span></div>
  <div class="detail-row"><span class="detail-label">Property</span><span class="detail-value">{{ $tenant->room->property->name }}</span></div>
  <div class="detail-row"><span class="detail-label">Lease Start</span><span class="detail-value">{{ $tenant->lease_start->format('d F Y') }}</span></div>
  <div class="detail-row"><span class="detail-label">Lease End</span><span class="detail-value">{{ $tenant->lease_end->format('d F Y') }}</span></div>
  <div class="detail-row"><span class="detail-label">Monthly Rent</span><span class="detail-value">${{ number_format($tenant->room->price,2) }}</span></div>
  <div class="detail-row"><span class="detail-label">Security Deposit</span><span class="detail-value">${{ number_format($tenant->deposit,2) }}</span></div>
  <div style="margin-top:18px;">
    <a href="{{ route('tenant.contracts.download') }}" class="btn btn-primary">Download Contract PDF</a>
  </div>
</div>
@endsection