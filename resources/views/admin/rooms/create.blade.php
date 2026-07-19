@extends('layouts.admin')
@section('title','Add Room')
@section('content')
<div class="page-header"><h2>Add Room</h2><a href="{{ route('admin.rooms.index') }}" class="btn">← Back</a></div>
<div class="card" style="max-width:600px;">
  <form method="POST" action="{{ route('admin.rooms.store') }}">
    @csrf
    <div class="form-group">
      <label>Property</label>
      <select name="property_id" class="form-control">
        @foreach($properties as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach
      </select>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
      <div class="form-group"><label>Room Number</label><input name="number" class="form-control" required></div>
      <div class="form-group">
        <label>Type</label>
        <select name="type" class="form-control">
          <option>Standard</option><option>Deluxe</option><option>Suite</option>
        </select>
      </div>
      <div class="form-group"><label>Floor</label><input name="floor" class="form-control" placeholder="1st"></div>
      <div class="form-group"><label>Size (m²)</label><input name="size" type="number" class="form-control"></div>
      <div class="form-group"><label>Price / Month ($)</label><input name="price" type="number" step="0.01" class="form-control" required></div>
    </div>
    <button class="btn btn-primary" type="submit">Create Room</button>
  </form>
</div>
@endsection