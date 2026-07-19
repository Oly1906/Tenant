@extends('layouts.admin')
@section('title','Announcements')
@section('content')
<div class="page-header">
  <h2>Announcements</h2>
  <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">+ New Announcement</a>
</div>
<div class="card">
  <table>
    <thead><tr><th>Title</th><th>Body</th><th>Expires</th><th>By</th><th>Date</th><th></th></tr></thead>
    <tbody>
      @foreach($announcements as $ann)
      <tr>
        <td style="font-weight:600;">{{ $ann->title }}</td>
        <td style="color:var(--muted);font-size:12px;max-width:240px;">{{ Str::limit($ann->body,80) }}</td>
        <td>{{ $ann->expires_at?->format('d M Y') ?? '–' }}</td>
        <td>{{ $ann->creator->name }}</td>
        <td>{{ $ann->created_at->diffForHumans() }}</td>
        <td>
          <form method="POST" action="{{ route('admin.announcements.destroy',$ann) }}" onsubmit="return confirm('Delete?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div style="margin-top:16px;">{{ $announcements->links() }}</div>
</div>
@endsection