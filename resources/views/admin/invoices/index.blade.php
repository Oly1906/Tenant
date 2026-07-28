@extends('layouts.admin')
@section('title','Invoices')
@section('content')
<div class="page-header">
  <h2>All Invoices</h2>
  <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary">+ New Invoice</a>
</div>
<div class="card">
  <table>
    <thead><tr><th>Invoice #</th><th>Tenant</th><th>Room</th><th>Month</th><th>Rent</th><th>Utilities</th><th>Total</th><th>Status</th><th></th></tr></thead>
    <tbody>
      @foreach($invoices as $inv)
      <tr>
        <td style="font-weight:700;">{{ $inv->invoice_number }}</td>
        <td>{{ $inv->tenant->user->name }}</td>
        <td>{{ $inv->tenant->room->number }}</td>
        <td>{{ $inv->month->format('d M Y') }}</td>
        <td>${{ number_format($inv->rent_amount,2) }}</td>
        <td>${{ number_format($inv->utility_amount,2) }}</td>
        <td style="font-weight:700;">${{ number_format($inv->total,2) }}</td>
        <td><span class="badge {{ $inv->status==='paid' ? 'badge-green' : 'badge-orange' }}">{{ ucfirst($inv->status) }}</span></td>
        <td style="display:flex;gap:6px;flex-wrap:wrap;">
          @if($inv->status==='pending')
          <form method="POST" action="{{ route('admin.invoices.markPaid',$inv) }}">
            @csrf @method('PATCH')
            <button class="btn btn-sm" style="background:#dcfce7;color:#15803d;">Mark Paid</button>
          </form>
          @endif
          <a href="{{ route('admin.invoices.download',$inv) }}" class="btn btn-sm" style="background:#eff6ff;color:var(--blue);">PDF</a>
          <form method="POST" action="{{ route('admin.invoices.destroy',$inv) }}" onsubmit="return confirm('Delete?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Del</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div style="margin-top:16px;">{{ $invoices->links() }}</div>
</div>
@endsection