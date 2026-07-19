@extends('layouts.admin')
@section('title','Add Utility Record')
@section('content')
<div class="page-header"><h2>Add Utility Record</h2><a href="{{ route('admin.utilities.index') }}" class="btn">← Back</a></div>
<div class="card" style="max-width:560px;">
  <form method="POST" action="{{ route('admin.utilities.store') }}">
    @csrf
    <div class="form-group">
      <label>Tenant</label>
      <select name="tenant_id" class="form-control" required>
        <option value="">Select tenant…</option>
        @foreach($tenants as $t)
          <option value="{{ $t->id }}">{{ $t->user->name }} — Room {{ $t->room->number }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group"><label>Month</label><input name="month" type="date" class="form-control" required value="{{ date('Y-m-01') }}"></div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
      <div class="form-group"><label>Electricity (kWh)</label><input name="electricity_kwh" type="number" step="0.01" class="form-control" value="0"></div>
      <div class="form-group"><label>Electricity Cost ($)</label><input name="electricity_cost" type="number" step="0.01" class="form-control" value="0"></div>
      <div class="form-group"><label>Water (m³)</label><input name="water_m3" type="number" step="0.01" class="form-control" value="0"></div>
      <div class="form-group"><label>Water Cost ($)</label><input name="water_cost" type="number" step="0.01" class="form-control" value="0"></div>
    </div>
    <button class="btn btn-primary" type="submit">Save Record</button>
  </form>
</div>
@endsection