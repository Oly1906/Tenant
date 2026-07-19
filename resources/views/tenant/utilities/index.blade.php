@extends('layouts.tenant')
@section('title','Utilities')
@section('content')
@foreach($records as $rec)
<div class="card">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
    <div style="font-size:15px;font-weight:700;">{{ $rec->month->format('F Y') }}</div>
  </div>
  <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 0;border-bottom:1px solid var(--border);">
    <div style="display:flex;align-items:center;gap:12px;">
      <div style="width:36px;height:36px;border-radius:10px;background:#fef3c7;display:flex;align-items:center;justify-content:center;">
        <svg viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" width="18" height="18"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
      </div>
      <div>
        <div style="font-size:13.5px;font-weight:600;">Electricity</div>
        <div style="font-size:12px;color:var(--muted);">{{ $rec->electricity_kwh }} kWh</div>
      </div>
    </div>
    <div style="font-size:16px;font-weight:700;">${{ number_format($rec->electricity_cost,2) }}</div>
  </div>
  <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 0;border-bottom:1px solid var(--border);">
    <div style="display:flex;align-items:center;gap:12px;">
      <div style="width:36px;height:36px;border-radius:10px;background:#eff6ff;display:flex;align-items:center;justify-content:center;">
        <svg viewBox="0 0 24 24" fill="none" stroke="#3b5bfc" stroke-width="2" width="18" height="18"><path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/></svg>
      </div>
      <div>
        <div style="font-size:13.5px;font-weight:600;">Water</div>
        <div style="font-size:12px;color:var(--muted);">{{ $rec->water_m3 }} m³</div>
      </div>
    </div>
    <div style="font-size:16px;font-weight:700;">${{ number_format($rec->water_cost,2) }}</div>
  </div>
  <div style="border-top:2px solid var(--border);margin-top:10px;padding-top:14px;display:flex;justify-content:space-between;align-items:center;">
    <div style="font-weight:700;font-size:14px;">Total</div>
    <div style="font-size:20px;font-weight:800;color:var(--blue);">${{ number_format($rec->total_cost,2) }}</div>
  </div>
</div>
@endforeach
<div style="margin-top:8px;">{{ $records->links() }}</div>
@endsection