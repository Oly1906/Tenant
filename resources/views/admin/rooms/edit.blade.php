@extends('layouts.admin')
@section('title','Edit Room')
@section('content')
<div class="page-header">
  <h2>Edit Room — {{ $room->number }}</h2>
  <a href="{{ route('admin.rooms.index') }}" class="btn">← Back</a>
</div>
<div class="card" style="max-width:600px;">
  <form method="POST" action="{{ route('admin.rooms.update',$room) }}">
    @csrf @method('PUT')
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
      <div class="form-group"><label>Room Number</label><input name="number" class="form-control" value="{{ $room->number }}" required></div>
      <div class="form-group">
        <label>Type</label>
        <select name="type" class="form-control">
          <option {{ $room->type==='Standard' ? 'selected' : '' }}>Standard</option>
          <option {{ $room->type==='Deluxe' ? 'selected' : '' }}>Deluxe</option>
          <option {{ $room->type==='Suite' ? 'selected' : '' }}>Suite</option>
        </select>
      </div>
      <div class="form-group"><label>Floor</label><input name="floor" class="form-control" value="{{ $room->floor }}"></div>
      <div class="form-group"><label>Size (m²)</label><input name="size" type="number" class="form-control" value="{{ $room->size }}"></div>
      <div class="form-group"><label>Price / Month ($)</label><input name="price" type="number" step="0.01" class="form-control" value="{{ $room->price }}" required></div>
      <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
          <option value="available" {{ $room->status==='available' ? 'selected' : '' }}>Available</option>
          <option value="occupied"  {{ $room->status==='occupied'  ? 'selected' : '' }}>Occupied</option>
        </select>
      </div>
    </div>
    <button class="btn btn-primary" type="submit">Save Changes</button>
  </form>
</div>
@endsection