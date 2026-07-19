@extends('layouts.admin')
@section('title','Edit Utility')
@section('content')
<div class="page-header">
  <h2>Edit Utility Record</h2>
  <a href="{{ route('admin.utilities.index') }}" class="btn">← Back</a>
</div>
<div class="card" style="max-width:560px;">
  <form method="POST" action="{{ route('admin.utilities.update',$record) }}">
    @csrf @method('PUT')
    <div class="form-group">
      <label>Tenant</label>
      <input value="{{ $record->tenant->user->name }} — Room {{ $record->tenant->room->number }}"
             class="form-control" disabled style="background:#f9fafb;color:var(--muted);">
    </div>
    <div class="form-group">
      <label>Month</label>
      <input name="month" type="date" class="form-control"
             value="{{ $record->month->format('Y-m-d') }}" required>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
      <div class="form-group">
        <label>Electricity (kWh)</label>
        <input name="electricity_kwh" type="number" step="0.01" class="form-control"
               value="{{ $record->electricity_kwh }}">
      </div>
      <div class="form-group">
        <label>Electricity Cost ($)</label>
        <input name="electricity_cost" type="number" step="0.01" class="form-control"
               value="{{ $record->electricity_cost }}">
      </div>
      <div class="form-group">
        <label>Water (m³)</label>
        <input name="water_m3" type="number" step="0.01" class="form-control"
               value="{{ $record->water_m3 }}">
      </div>
      <div class="form-group">
        <label>Water Cost ($)</label>
        <input name="water_cost" type="number" step="0.01" class="form-control"
               value="{{ $record->water_cost }}">
      </div>
    </div>
    <button class="btn btn-primary" type="submit">Save Changes</button>
  </form>
</div>
@endsection