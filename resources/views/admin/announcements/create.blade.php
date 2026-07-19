@extends('layouts.admin')
@section('title','New Announcement')
@section('content')
<div class="page-header"><h2>Publish Announcement</h2><a href="{{ route('admin.announcements.index') }}" class="btn">← Back</a></div>
<div class="card" style="max-width:560px;">
  <form method="POST" action="{{ route('admin.announcements.store') }}">
    @csrf
    <div class="form-group"><label>Title</label><input name="title" class="form-control" required value="{{ old('title') }}"></div>
    <div class="form-group"><label>Message</label><textarea name="body" class="form-control" rows="5" required>{{ old('body') }}</textarea></div>
    <div class="form-group"><label>Expires At (optional)</label><input name="expires_at" type="date" class="form-control"></div>
    <button class="btn btn-primary" type="submit">Publish</button>
  </form>
</div>
@endsection