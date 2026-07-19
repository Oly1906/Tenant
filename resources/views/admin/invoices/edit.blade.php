@extends('layouts.admin')
@section('title','Edit Invoice')
@section('content')
<div class="page-header">
  <h2>Edit Invoice — {{ $invoice->invoice_number }}</h2>
  <a href="{{ route('admin.invoices.index') }}" class="btn">← Back</a>
</div>
<div class="card" style="max-width:500px;">
  <form method="POST" action="{{ route('admin.invoices.update',$invoice) }}">
    @csrf @method('PUT')
    <div class="form-group">
      <label>Tenant</label>
      <input value="{{ $invoice->tenant->user->name }} — Room {{ $invoice->tenant->room->number }}"
             class="form-control" disabled style="background:#f9fafb;color:var(--muted);">
    </div>
    <div class="form-group"><label>Month</label>
      <input name="month" type="date" class="form-control"
             value="{{ $invoice->month->format('Y-m-d') }}" required>
    </div>
    <div class="form-group"><label>Utility Amount ($)</label>
      <input name="utility_amount" type="number" step="0.01" class="form-control"
             value="{{ $invoice->utility_amount }}">
    </div>
    <div class="form-group"><label>Due Date</label>
      <input name="due_date" type="date" class="form-control"
             value="{{ $invoice->due_date?->format('Y-m-d') }}">
    </div>
    <div class="form-group">
      <label>Status</label>
      <select name="status" class="form-control">
        <option value="pending"  {{ $invoice->status==='pending' ? 'selected':'' }}>Pending</option>
        <option value="paid"     {{ $invoice->status==='paid'    ? 'selected':'' }}>Paid</option>
      </select>
    </div>
    <button class="btn btn-primary" type="submit">Save Changes</button>
  </form>
</div>
@endsection