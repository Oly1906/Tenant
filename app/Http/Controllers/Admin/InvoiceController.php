<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Invoice, Tenant, UtilityRecord};
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['tenant.user', 'tenant.room'])->latest()->paginate(20);
        return view('admin.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $tenants = Tenant::with(['user', 'room'])->where('status', 'active')->get();
        return view('admin.invoices.create', compact('tenants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tenant_id'      => 'required|exists:tenants,id',
            'month'          => 'required|date',
            'utility_amount' => 'nullable|numeric|min:0',
            'due_date'       => 'nullable|date',
        ]);

        $tenant  = Tenant::find($request->tenant_id);
        $utility = $request->utility_amount ?? 0;
        $total   = $tenant->room->price + $utility;

        // Create unique invoice number
        do {
            $lastId = Invoice::max('id') ?? 0;
            $number = 'INV-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
            // If already exists, append a random suffix and retry
            if (Invoice::where('invoice_number', $number)->exists()) {
                $number .= '-' . rand(1, 99);
            }
        } while (Invoice::where('invoice_number', $number)->exists());

        Invoice::create([
            'invoice_number' => $number,
            'tenant_id'      => $tenant->id,
            'rent_amount'    => $tenant->room->price,
            'utility_amount' => $utility,
            'total'          => $total,
            'month'          => $request->month,
            'due_date'       => $request->due_date,
        ]);

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Invoice created.');
    }

    public function markPaid(Invoice $invoice)
    {
        $invoice->update(['status' => 'paid', 'paid_date' => now()]);
        return back()->with('success', 'Invoice marked as paid.');
    }

    public function download(Invoice $invoice)
    {
        $invoice->load(['tenant.user', 'tenant.room.property']);
        $pdf = Pdf::loadView('admin.invoices.pdf', compact('invoice'));
        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return back()->with('success', 'Invoice deleted.');
    }

    public function edit(Invoice $invoice)
    {
        return view('admin.invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'month'          => 'required|date',
            'utility_amount' => 'nullable|numeric|min:0',
            'due_date'       => 'nullable|date',
            'status'         => 'required|in:pending,paid',
        ]);

        $total = $invoice->rent_amount + ($request->utility_amount ?? 0);

        $invoice->update([
            'utility_amount' => $request->utility_amount ?? 0,
            'total'          => $total,
            'month'          => $request->month,
            'due_date'       => $request->due_date,
            'status'         => $request->status,
            'paid_date'      => $request->status === 'paid' ? now() : null,
        ]);

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice updated.');
    }
}