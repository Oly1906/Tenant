@extends('layouts.admin')
@section('title','Add Utility Record')
@section('content')
<div class="page-header">
  <h2>Add Utility Record</h2>
  <a href="{{ route('admin.utilities.index') }}" class="btn">← Back</a>
</div>

<div class="card" style="max-width:600px;">
  <form method="POST" action="{{ route('admin.utilities.store') }}">
    @csrf

    {{-- Tenant --}}
    <div class="form-group">
      <label>Tenant</label>
      <select name="tenant_id" class="form-control" required>
        <option value="">Select tenant…</option>
        @foreach($tenants as $t)
          <option value="{{ $t->id }}">{{ $t->user->name }} — Room {{ $t->room->number }}</option>
        @endforeach
      </select>
    </div>

    {{-- Month --}}
    <div class="form-group">
      <label>Month</label>
      <input name="month" type="date" class="form-control" required value="{{ date('Y-m-01') }}">
    </div>

    {{-- ភ្លើង --}}
    <div style="background:#f8faff;border:1px solid #dbe4ff;border-radius:8px;padding:16px;margin-bottom:16px;">
      <div style="font-weight:700;margin-bottom:12px;color:#3b5bdb;">⚡ ភ្លើង (Electricity)</div>
      <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
        <div class="form-group">
          <label>លេខចាស់ (Old)</label>
          <input id="e_old" name="electricity_old" type="number" step="0.01" min="0"
                 class="form-control" value="{{ old('electricity_old',0) }}" oninput="calc()">
        </div>
        <div class="form-group">
          <label>លេខថ្មី (New)</label>
          <input id="e_new" name="electricity_new" type="number" step="0.01" min="0"
                 class="form-control" value="{{ old('electricity_new',0) }}" oninput="calc()">
        </div>
        <div class="form-group">
          <label>តម្លៃ/kWh ($)</label>
          <input id="e_rate" name="electricity_rate" type="number" step="0.01" min="0"
                 class="form-control" value="{{ old('electricity_rate',0.25) }}" oninput="calc()">
        </div>
      </div>
      {{-- Preview ភ្លើង --}}
      <div style="background:#fff;border-radius:6px;padding:10px 14px;font-size:13px;color:#555;">
        ប្រើប្រាស់: <strong id="e_usage">0</strong> kWh &nbsp;×&nbsp;
        តម្លៃ: <strong id="e_rate_show">0.25</strong> &nbsp;=&nbsp;
        <span style="color:#3b5bdb;font-weight:700;">$ <span id="e_cost">0.00</span></span>
      </div>
    </div>

    {{-- ទឹក --}}
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:16px;margin-bottom:16px;">
      <div style="font-weight:700;margin-bottom:12px;color:#16a34a;">💧 ទឹក (Water)</div>
      <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
        <div class="form-group">
          <label>លេខចាស់ (Old)</label>
          <input id="w_old" name="water_old" type="number" step="0.01" min="0"
                 class="form-control" value="{{ old('water_old',0) }}" oninput="calc()">
        </div>
        <div class="form-group">
          <label>លេខថ្មី (New)</label>
          <input id="w_new" name="water_new" type="number" step="0.01" min="0"
                 class="form-control" value="{{ old('water_new',0) }}" oninput="calc()">
        </div>
        <div class="form-group">
          <label>តម្លៃ/m³ ($)</label>
          <input id="w_rate" name="water_rate" type="number" step="0.01" min="0"
                 class="form-control" value="{{ old('water_rate',0.50) }}" oninput="calc()">
        </div>
      </div>
      {{-- Preview ទឹក --}}
      <div style="background:#fff;border-radius:6px;padding:10px 14px;font-size:13px;color:#555;">
        ប្រើប្រាស់: <strong id="w_usage">0</strong> m³ &nbsp;×&nbsp;
        តម្លៃ: <strong id="w_rate_show">0.50</strong> &nbsp;=&nbsp;
        <span style="color:#16a34a;font-weight:700;">$ <span id="w_cost">0.00</span></span>
      </div>
    </div>

    {{-- សរុប --}}
    <div style="text-align:right;font-size:16px;font-weight:700;margin-bottom:16px;">
      សរុបទាំងអស់: <span style="color:#e53e3e;font-size:20px;">$ <span id="total">0.00</span></span>
    </div>

    @if($errors->any())
      <div style="color:red;margin-bottom:12px;">
        @foreach($errors->all() as $e) <div>• {{ $e }}</div> @endforeach
      </div>
    @endif

    <button class="btn btn-primary" type="submit">Save Record</button>
  </form>
</div>

<script>
function calc() {
  const eOld  = parseFloat(document.getElementById('e_old').value)  || 0;
  const eNew  = parseFloat(document.getElementById('e_new').value)  || 0;
  const eRate = parseFloat(document.getElementById('e_rate').value) || 0;

  const wOld  = parseFloat(document.getElementById('w_old').value)  || 0;
  const wNew  = parseFloat(document.getElementById('w_new').value)  || 0;
  const wRate = parseFloat(document.getElementById('w_rate').value) || 0;

  const eUsage = Math.max(0, eNew - eOld);
  const eCost  = eUsage * eRate;

  const wUsage = Math.max(0, wNew - wOld);
  const wCost  = wUsage * wRate;

  document.getElementById('e_usage').textContent    = eUsage.toFixed(2);
  document.getElementById('e_rate_show').textContent = eRate.toFixed(2);
  document.getElementById('e_cost').textContent      = eCost.toFixed(2);

  document.getElementById('w_usage').textContent    = wUsage.toFixed(2);
  document.getElementById('w_rate_show').textContent = wRate.toFixed(2);
  document.getElementById('w_cost').textContent      = wCost.toFixed(2);

  document.getElementById('total').textContent = (eCost + wCost).toFixed(2);
}
calc(); // គណនាដំបូងពេល load
</script>
@endsection