<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
  body{font-family:DejaVu Sans,sans-serif;color:#1a1f3c;padding:50px;font-size:13px;line-height:1.6;}
  h1{font-size:20px;color:#3b5bfc;margin-bottom:4px;}
  .section{margin:24px 0;}
  .section h3{font-size:14px;font-weight:bold;border-bottom:2px solid #e5e9f5;padding-bottom:6px;margin-bottom:12px;}
  table{width:100%;border-collapse:collapse;}
  td{padding:8px 0;border-bottom:1px solid #f0f4ff;font-size:13px;}
  td:last-child{font-weight:600;text-align:right;}
  .footer{margin-top:60px;border-top:1px solid #e5e9f5;padding-top:20px;font-size:11px;color:#6b7280;}
  .sig-box{display:inline-block;width:200px;border-bottom:1px solid #1a1f3c;margin-top:40px;margin-right:60px;}
</style>
</head>
<body>
<h1>LEASE AGREEMENT</h1>
<p style="color:#6b7280;font-size:12px;">Generated {{ now()->format('d F Y') }}</p>

<div class="section">
  <h3>Parties</h3>
  <table>
    <tr><td>Landlord / Property</td><td>{{ $tenant->room->property->name }}</td></tr>
    <tr><td>Address</td><td>{{ $tenant->room->property->address }}</td></tr>
    <tr><td>Tenant</td><td>{{ $tenant->user->name }}</td></tr>
    <tr><td>Email</td><td>{{ $tenant->user->email }}</td></tr>
    <tr><td>Phone</td><td>{{ $tenant->user->phone ?? 'N/A' }}</td></tr>
  </table>
</div>

<div class="section">
  <h3>Rental Details</h3>
  <table>
    <tr><td>Room Number</td><td>{{ $tenant->room->number }}</td></tr>
    <tr><td>Room Type</td><td>{{ $tenant->room->type }}</td></tr>
    <tr><td>Lease Start</td><td>{{ $tenant->lease_start->format('d F Y') }}</td></tr>
    <tr><td>Lease End</td><td>{{ $tenant->lease_end->format('d F Y') }}</td></tr>
    <tr><td>Monthly Rent</td><td>${{ number_format($tenant->room->price,2) }}</td></tr>
    <tr><td>Security Deposit</td><td>${{ number_format($tenant->deposit,2) }}</td></tr>
  </table>
</div>

<div class="section">
  <h3>Signatures</h3>
  <div class="sig-box"></div>
  <div class="sig-box"></div>
  <br>
  <div style="display:inline-block;width:200px;font-size:11px;color:#6b7280;margin-right:60px;">Landlord / Management</div>
  <div style="display:inline-block;width:200px;font-size:11px;color:#6b7280;">{{ $tenant->user->name }}</div>
</div>

<div class="footer">This document is auto-generated. For queries contact management.</div>
</body>
</html>