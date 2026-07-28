@extends('layouts.admin')
@section('title','Payments')
@section('content')
<div class="page-header"><h2>Payments</h2></div>
<div class="kpi-grid">
  <div class="kpi-card">
    <div class="kpi-label">Collected This Month</div>
    <div class="kpi-value" style="font-size:22px;">${{ number_format($totalCollected,2) }}</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-label">Outstanding</div>
    <div class="kpi-value" style="font-size:22px;color:var(--orange);">${{ number_format($outstanding,2) }}</div>
  </div>
</div>
<div class="card">
  <table>
    <thead>
      <tr>
        <th>Tenant</th>
        <th>Room</th>
        <th>Month</th>
        <th>Rent</th>
        <th>Utilities</th>
        <th>Total</th>
        {{-- <th>Due</th> --}}
        <th>Paid</th>
        <th>Status</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($invoices as $inv)
      <tr>
        <td>{{ $inv->tenant->user->name }}</td>
        <td>{{ $inv->tenant->room->number }}</td>
        <td>{{ $inv->month->format('d M ') }}</td>
        <td>${{ number_format($inv->rent_amount,2) }}</td>
        <td>${{ number_format($inv->utility_amount,2) }}</td>
        <td style="font-weight:700;">${{ number_format($inv->total,2) }}</td>
        {{-- <td>{{ $inv->due_date?->format('d M Y') ?? '–' }}</td> --}}
        <td>{{ $inv->paid_date?->format('d M Y') ?? '–' }}</td>
        <td><span class="badge {{ $inv->status==='paid' ? 'badge-green' : 'badge-orange' }}">{{ ucfirst($inv->status) }}</span></td>
        <td>
          @if($inv->status==='pending')
          <form method="POST" action="{{ route('admin.invoices.markPaid',$inv) }}">
            @csrf @method('PATCH')
            <button class="btn btn-sm" style="background:#dcfce7;color:#15803d;">Mark Paid</button>
          </form>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div style="margin-top:16px;">{{ $invoices->links() }}</div>
</div>
@endsection