@extends('layouts.tenant')
@section('title','Dashboard')
@section('content')
<div style="background:linear-gradient(135deg,#3b5bfc,#6b3ef5);border-radius:16px;padding:22px 24px;color:white;display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
  <div>
    <h2 style="font-size:22px;font-weight:700;margin-bottom:4px;">Welcome back, {{ auth()->user()->name }} 👋</h2>
    <p style="opacity:.75;font-size:13px;">Here's what's happening with your tenancy today.</p>
  </div>
  @if($pendingInvoice)
  <div style="background:rgba(255,255,255,.15);border-radius:12px;padding:14px 18px;text-align:center;">
    <div style="font-size:11px;opacity:.7;">Current Rent Due</div>
    <div style="font-size:24px;font-weight:800;">${{ number_format($pendingInvoice->total,2) }}</div>
    <div style="font-size:11px;margin-top:6px;background:rgba(239,68,68,.3);border-radius:6px;padding:3px 8px;">
      Due {{ $pendingInvoice->due_date?->format('d M Y') }}
    </div>
  </div>
  @endif
</div>

<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:20px;">
  <div class="card" style="padding:18px;">
    <div style="width:38px;height:38px;border-radius:10px;background:#fef3c7;display:flex;align-items:center;justify-content:center;margin-bottom:12px;">
      <svg viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" width="20" height="20"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
    </div>
    <div style="font-size:22px;font-weight:800;">{{ $latestUtility?->electricity_kwh ?? '–' }} kWh</div>
    <div style="font-size:12px;color:var(--muted);margin-top:3px;">Electricity this month</div>
  </div>
  <div class="card" style="padding:18px;">
    <div style="width:38px;height:38px;border-radius:10px;background:#eff6ff;display:flex;align-items:center;justify-content:center;margin-bottom:12px;">
      <svg viewBox="0 0 24 24" fill="none" stroke="#3b5bfc" stroke-width="2" width="20" height="20"><path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/></svg>
    </div>
    <div style="font-size:22px;font-weight:800;">{{ $latestUtility?->water_m3 ?? '–' }} m³</div>
    <div style="font-size:12px;color:var(--muted);margin-top:3px;">Water this month</div>
  </div>
  <div class="card" style="padding:18px;">
    <div style="width:38px;height:38px;border-radius:10px;background:#fef3c7;display:flex;align-items:center;justify-content:center;margin-bottom:12px;">
      <svg viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" width="20" height="20"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
    </div>
    <div style="font-size:22px;font-weight:800;">${{ $pendingInvoice ? number_format($pendingInvoice->total,2) : '0.00' }}</div>
    <div style="font-size:12px;color:var(--muted);margin-top:3px;">Outstanding balance</div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
  <div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
      <div style="font-size:15px;font-weight:700;">Recent Invoices</div>
      <a href="{{ route('tenant.invoices.index') }}" style="font-size:12px;color:var(--blue);font-weight:600;">View All</a>
    </div>
    <table>
      <thead><tr><th>Invoice</th><th>Month</th><th>Total</th><th>Status</th></tr></thead>
      <tbody>
        @foreach($recentInvoices as $inv)
        <tr>
          <td style="font-weight:700;">{{ $inv->invoice_number }}</td>
          <td>{{ $inv->month->format('M Y') }}</td>
          <td>${{ number_format($inv->total,2) }}</td>
          <td><span class="badge {{ $inv->status==='paid' ? 'badge-green' : 'badge-orange' }}">{{ ucfirst($inv->status) }}</span></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="card">
    <div style="font-size:15px;font-weight:700;margin-bottom:14px;">Recent Announcements</div>
    @foreach($announcements as $ann)
    <div style="padding:12px 0;border-bottom:1px solid var(--border);">
      <div style="font-weight:700;font-size:13px;">{{ $ann->title }}</div>
      <div style="color:var(--muted);font-size:12px;margin-top:3px;line-height:1.5;">{{ Str::limit($ann->body,100) }}</div>
      <div style="color:var(--muted);font-size:11px;margin-top:4px;">{{ $ann->created_at->diffForHumans() }}</div>
    </div>
    @endforeach
  </div>
</div>
@endsection