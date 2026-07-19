@extends('layouts.tenant')
@section('title','Invoices')
@section('content')
<div class="card">
  <div style="font-size:15px;font-weight:700;margin-bottom:16px;">My Invoices</div>
  <table>
    <thead><tr><th>Invoice #</th><th>Month</th><th>Rent</th><th>Utilities</th><th>Total</th><th>Status</th><th></th></tr></thead>
    <tbody>
      @foreach($invoices as $inv)
      <tr>
        <td style="font-weight:700;">{{ $inv->invoice_number }}</td>
        <td>{{ $inv->month->format('M Y') }}</td>
        <td>${{ number_format($inv->rent_amount,2) }}</td>
        <td>${{ number_format($inv->utility_amount,2) }}</td>
        <td style="font-weight:700;">${{ number_format($inv->total,2) }}</td>
        <td><span class="badge {{ $inv->status==='paid' ? 'badge-green' : 'badge-orange' }}">{{ ucfirst($inv->status) }}</span></td>
        <td><a href="{{ route('tenant.invoices.download',$inv) }}" class="btn btn-primary" style="font-size:12px;font-weight:600;">Download</a></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div style="margin-top:16px;">{{ $invoices->links() }}</div>
</div>
@endsection