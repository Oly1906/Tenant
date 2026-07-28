<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Invoice, Tenant};
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
            'tenant_id' => 'required|exists:tenants,id',
            'type'      => 'required|in:rent,utility',
            'month'     => 'required|date',
            'due_date'  => 'nullable|date',
            'rent_amount' => 'required_if:type,rent|nullable|numeric|min:0',
        ]);

        $number = 'INV-' . str_pad((Invoice::max('id') ?? 0) + 1, 4, '0', STR_PAD_LEFT);

        $data = [
            'invoice_number' => $number,
            'tenant_id'      => $request->tenant_id,
            'type'           => $request->type,
            'month'          => $request->month,
            'due_date'       => $request->due_date,
            'status'         => 'pending',
        ];

        if ($request->type === 'rent') {
            $data['rent_amount'] = $request->rent_amount;
            $data['total']       = $request->rent_amount;
        }

        if ($request->type === 'utility') {
            // ទាញ UtilityRecord ដែល add រួចហើយ (ខែដដែល)
            $utility = UtilityRecord::where('tenant_id', $request->tenant_id)
                ->where('month', $request->month)
                ->first();

            if (!$utility) {
                return back()
                    ->withInput()
                    ->withErrors(['month' => 'រកមិនឃើញ Utility Record សម្រាប់ខែ ' . $request->month . ' — សូម Add Utility ជាមុន។']);
            }

            $data += [
                'electricity_old'   => $utility->electricity_old,
                'electricity_new'   => $utility->electricity_new,
                'electricity_rate'  => $utility->electricity_rate,
                'electricity_usage' => $utility->electricity_usage,
                'electricity_cost'  => $utility->electricity_cost,
                'water_old'         => $utility->water_old,
                'water_new'         => $utility->water_new,
                'water_rate'        => $utility->water_rate,
                'water_usage'       => $utility->water_usage,
                'water_cost'        => $utility->water_cost,
                'total'             => $utility->total_cost,
            ];
        }

        Invoice::create($data);
        return redirect()->route('admin.invoices.index')->with('success', 'Invoice created.');
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
        $tenants = Tenant::with(['user', 'room'])->where('status', 'active')->get();
        return view('admin.invoices.edit', compact('invoice', 'tenants'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'month'    => 'required|date',
            'due_date' => 'nullable|date',
            'status'   => 'required|in:pending,paid',
        ]);

        if ($invoice->type === 'rent') {
            $invoice->update([
                'rent_amount' => $request->rent_amount,
                'total'       => $request->rent_amount,
                'month'       => $request->month,
                'due_date'    => $request->due_date,
                'status'      => $request->status,
                'paid_date'   => $request->status === 'paid' ? now() : null,
            ]);
        }

        if ($invoice->type === 'utility') {
            $eUsage = $request->electricity_new - $request->electricity_old;
            $eCost  = $eUsage * $request->electricity_rate;
            $wUsage = $request->water_new - $request->water_old;
            $wCost  = $wUsage * $request->water_rate;

            $invoice->update([
                'electricity_old'   => $request->electricity_old,
                'electricity_new'   => $request->electricity_new,
                'electricity_rate'  => $request->electricity_rate,
                'electricity_usage' => $eUsage,
                'electricity_cost'  => $eCost,
                'water_old'         => $request->water_old,
                'water_new'         => $request->water_new,
                'water_rate'        => $request->water_rate,
                'water_usage'       => $wUsage,
                'water_cost'        => $wCost,
                'total'             => $eCost + $wCost,
                'month'             => $request->month,
                'due_date'          => $request->due_date,
                'status'            => $request->status,
                'paid_date'         => $request->status === 'paid' ? now() : null,
            ]);
        }

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice updated.');
    }
}