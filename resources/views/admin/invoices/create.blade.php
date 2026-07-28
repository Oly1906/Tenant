@extends('layouts.admin')
@section('title','New Invoice')
@section('content')
<div class="page-header">
  <h2>Create Invoice</h2>
  <a href="{{ route('admin.invoices.index') }}" class="btn">← Back</a>
</div>

<div class="card" style="max-width:580px;">
  <form method="POST" action="{{ route('admin.invoices.store') }}">
    @csrf

    <div class="form-group">
      <label>Tenant</label>
      <select name="tenant_id" class="form-control" required>
        <option value="">Select tenant…</option>
        @foreach($tenants as $t)
          <option value="{{ $t->id }}" data-price="{{ $t->room->price }}">
            {{ $t->user->name }} — Room {{ $t->room->number }} (${{ $t->room->price }}/mo)
          </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label>ប្រភេទ Invoice</label>
      <select name="type" id="inv-type" class="form-control" required onchange="toggleType()">
        <option value="">-- ជ្រើសរើស --</option>
        <option value="rent">🏠 ថ្លៃជួលបន្ទប់ (Rent)</option>
        <option value="utility">⚡💧 ថ្លៃទឹកភ្លើង (Utility)</option>
      </select>
    </div>

    <div class="form-group">
      <label>Month</label>
      <input name="month" type="date" class="form-control" required value="{{ date('Y-m-01') }}">
    </div>

    {{-- Due Date --}}
    {{-- <div class="form-group">
      <label>Due Date</label>
      <input id="due-date" name="due_date" type="date" class="form-control">
    </div> --}}

    {{-- RENT SECTION --}}
    <div id="section-rent" style="display:none;">
      <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:16px;margin-bottom:16px;">
        <div style="font-weight:700;margin-bottom:12px;color:#1d4ed8;">🏠 ថ្លៃជួលបន្ទប់</div>
        <div class="form-group">
          <label>ថ្លៃជួល ($)</label>
          <input id="rent-amount" name="rent_amount" type="number" step="0.01" class="form-control" value="0">
        </div>
        <div style="background:#fff;border-radius:6px;padding:10px 14px;font-size:13px;">
          សរុប: <strong style="color:#1d4ed8;font-size:16px;">$ <span id="rent-total">0.00</span></strong>
        </div>
      </div>
    </div>

    {{-- UTILITY SECTION --}}
    <div id="section-utility" style="display:none;">
      <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:16px;margin-bottom:12px;">
        <div style="font-weight:700;margin-bottom:8px;color:#16a34a;">⚡💧 ទិន្នន័យទឹកភ្លើង (Auto)</div>
        <div id="utility-preview" style="color:#6b7280;font-size:13px;padding:8px;">
          — ជ្រើស Tenant និង Month ដើម្បីមើលទិន្នន័យ —
        </div>
      </div>
    </div>

    @if($errors->any())
      <div style="color:red;margin:12px 0;">
        @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
      </div>
    @endif

    <button class="btn btn-primary" type="submit" style="margin-top:16px;">Generate Invoice</button>
  </form>
</div>

<script>
function toggleType() {
  const type = document.getElementById('inv-type').value;
  document.getElementById('section-rent').style.display    = type === 'rent'    ? 'block' : 'none';
  document.getElementById('section-utility').style.display = type === 'utility' ? 'block' : 'none';
  if (type === 'utility') fetchUtility();
}

function fetchUtility() {
  const tenantId = document.querySelector('[name=tenant_id]').value;
  const month    = document.querySelector('[name=month]').value;
  const preview  = document.getElementById('utility-preview');

  if (!tenantId || !month) {
    preview.innerHTML = '<span style="color:#6b7280;">— ជ្រើស Tenant និង Month ដើម្បីមើលទិន្នន័យ —</span>';
    return;
  }

  preview.innerHTML = 'កំពុងផ្ទុក...';

  fetch(`/admin/utilities/preview?tenant_id=${tenantId}&month=${month}`)
    .then(r => r.json())
    .then(data => {
      if (data.error) {
        preview.innerHTML = `<span style="color:red;">⚠️ ${data.error}</span>`;
        return;
      }
      preview.innerHTML = `
        <table style="width:100%;font-size:13px;border-collapse:collapse;">
          <tr style="border-bottom:1px solid #e5e7eb;">
            <td style="padding:6px 0;">⚡ ភ្លើង</td>
            <td>${data.electricity_old} → ${data.electricity_new}</td>
            <td>${data.electricity_usage} kWh × $${data.electricity_rate}</td>
            <td style="font-weight:700;color:#3b5bdb;">$${data.electricity_cost}</td>
          </tr>
          <tr style="border-bottom:1px solid #e5e7eb;">
            <td style="padding:6px 0;">💧 ទឹក</td>
            <td>${data.water_old} → ${data.water_new}</td>
            <td>${data.water_usage} m³ × $${data.water_rate}</td>
            <td style="font-weight:700;color:#16a34a;">$${data.water_cost}</td>
          </tr>
          <tr>
            <td colspan="3" style="padding:6px 0;font-weight:700;">សរុប</td>
            <td style="font-weight:700;color:#e53e3e;font-size:15px;">$${data.total_cost}</td>
          </tr>
        </table>`;
    });
}

// Auto-fill rent
document.querySelector('[name=tenant_id]').addEventListener('change', function() {
  const price = this.options[this.selectedIndex].dataset.price || 0;
  document.getElementById('rent-amount').value = price;
  document.getElementById('rent-total').textContent = parseFloat(price).toFixed(2);
  if (document.getElementById('inv-type').value === 'utility') fetchUtility();
});

document.querySelector('[name=month]').addEventListener('change', function() {
  if (document.getElementById('inv-type').value === 'utility') fetchUtility();
});

document.getElementById('rent-amount').addEventListener('input', function() {
  document.getElementById('rent-total').textContent = (parseFloat(this.value) || 0).toFixed(2);
});

// Auto-set due date ពេលជ្រើស month
// document.querySelector('[name=month]').addEventListener('change', function() {
//   if (this.value) {
//     // due date = ថ្ងៃទី 15 នៃខែដែលជ្រើស
//     const d = new Date(this.value);
//     d.setDate(15);
//     document.getElementById('due-date').value = d.toISOString().split('T')[0];
//   }
//   if (document.getElementById('inv-type').value === 'utility') fetchUtility();
// });

</script>
@endsection