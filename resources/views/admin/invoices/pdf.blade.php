<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
  body{font-family:DejaVu Sans,sans-serif;color:#1a1f3c;padding:40px;font-size:13px;}
  .header{display:flex;justify-content:space-between;margin-bottom:32px;}
  .company{font-size:20px;font-weight:bold;color:#3b5bfc;}
  .inv-num{font-size:14px;color:#6b7280;}
  h2{font-size:16px;margin-bottom:4px;}
  table{width:100%;border-collapse:collapse;margin:20px 0;}
  th{background:#f0f4ff;padding:10px;text-align:left;font-size:12px;font-weight:600;}
  td{padding:10px;border-bottom:1px solid #e5e9f5;font-size:13px;}
  .total-row td{font-weight:bold;font-size:14px;background:#f0f4ff;}
  .badge{padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;}
  .paid{background:#dcfce7;color:#15803d;}
  .pending{background:#fef3c7;color:#b45309;}
  .footer{margin-top:40px;color:#6b7280;font-size:11px;text-align:center;}
</style>
</head>
<body>
<div class="header">
  <div>
    <div class="company">{{ $invoice->tenant->room->property->name ?? 'Property Manager' }}</div>
    <div style="color:#6b7280;margin-top:4px;">{{ $invoice->tenant->room->property->address ?? '' }}</div>
  </div>
  <div style="text-align:right;">
    <div class="inv-num">{{ $invoice->invoice_number }}</div>
    <div style="font-size:11px;color:#6b7280;margin-top:4px;">{{ $invoice->month->format('F Y') }}</div>
    <div style="margin-top:8px;"><span class="badge {{ $invoice->status==='paid' ? 'paid' : 'pending' }}">{{ ucfirst($invoice->status) }}</span></div>
  </div>
</div>

<div style="display:flex;gap:40px;margin-bottom:24px;">
  <div>
    <div style="font-size:11px;color:#6b7280;text-transform:uppercase;margin-bottom:6px;">Billed To</div>
    <div style="font-weight:bold;">{{ $invoice->tenant->user->name }}</div>
    <div>{{ $invoice->tenant->user->email }}</div>
    <div>Room {{ $invoice->tenant->room->number }}</div>
  </div>
  <div>
    <div style="font-size:11px;color:#6b7280;text-transform:uppercase;margin-bottom:6px;">Details</div>
    <div>Issued: {{ $invoice->created_at->format('d M Y') }}</div>
    <div>Due: {{ $invoice->due_date?->format('d M Y') ?? 'N/A' }}</div>
    @if($invoice->paid_date)<div>Paid: {{ $invoice->paid_date->format('d M Y') }}</div>@endif
  </div>
</div>

<table>
  <thead><tr><th>Description</th><th style="text-align:right;">Amount</th></tr></thead>
  <tbody>
    <tr><td>Monthly Rent — {{ $invoice->month->format('F Y') }}</td><td style="text-align:right;">${{ number_format($invoice->rent_amount,2) }}</td></tr>
    @if($invoice->utility_amount > 0)
    <tr><td>Utilities — Electricity &amp; Water</td><td style="text-align:right;">${{ number_format($invoice->utility_amount,2) }}</td></tr>
    @endif
  </tbody>
  <tfoot>
    <tr class="total-row"><td>TOTAL</td><td style="text-align:right;">${{ number_format($invoice->total,2) }}</td></tr>
  </tfoot>
</table>

<div class="footer">Thank you. Please contact management if you have any questions.</div>
</body>
</html>