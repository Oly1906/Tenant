@extends('layouts.admin')
@section('title','New Invoice')
@section('content')
<div class="page-header"><h2>Create Invoice</h2><a href="{{ route('admin.invoices.index') }}" class="btn">← Back</a></div>
<div class="card" style="max-width:500px;">
  <form method="POST" action="{{ route('admin.invoices.store') }}">
    @csrf
    <div class="form-group">
      <label>Tenant</label>
      <select name="tenant_id" class="form-control" required>
        <option value="">Select tenant…</option>
        @foreach($tenants as $t)
          <option value="{{ $t->id }}">{{ $t->user->name }} — Room {{ $t->room->number }} (${{ $t->room->price }}/mo)</option>
        @endforeach
      </select>
    </div>
    <div class="form-group"><label>Month</label><input name="month" type="date" class="form-control" required value="{{ date('Y-m-01') }}"></div>
    <div class="form-group"><label>Utility Amount ($)</label><input name="utility_amount" type="number" step="0.01" class="form-control" value="0"></div>
    <div class="form-group"><label>Due Date</label><input name="due_date" type="date" class="form-control"></div>
    <button class="btn btn-primary" type="submit">Generate Invoice</button>
  </form>
</div>
@endsection