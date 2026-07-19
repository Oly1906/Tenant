@extends('layouts.tenant')
@section('title','Announcements')
@section('content')
<div class="card">
  <div class="card-title">All Announcements</div>
  @forelse($announcements as $ann)
  <div style="display:flex;gap:14px;padding:14px 0;border-bottom:1px solid var(--border);">
    <div style="width:40px;height:40px;border-radius:10px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
      <svg viewBox="0 0 24 24" fill="none" stroke="#3b5bfc" stroke-width="2" width="20" height="20"><path d="M22 17H2a3 3 0 000 6h20M18 12V6a6 6 0 00-12 0v6"/></svg>
    </div>
    <div>
      <div style="font-size:13.5px;font-weight:700;">{{ $ann->title }}</div>
      <div style="font-size:13px;color:var(--muted);margin-top:3px;line-height:1.5;">{{ $ann->body }}</div>
      <div style="font-size:11px;color:var(--muted);margin-top:5px;">{{ $ann->created_at->diffForHumans() }} · From Management</div>
    </div>
  </div>
  @empty
  <p style="color:var(--muted);text-align:center;padding:20px 0;">No announcements yet.</p>
  @endforelse
  <div style="margin-top:16px;">{{ $announcements->links() }}</div>
</div>
@endsection