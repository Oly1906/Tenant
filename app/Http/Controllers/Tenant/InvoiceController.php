<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $tenant   = Auth::user()->tenant;
        $invoices = $tenant->invoices()->latest()->paginate(10);
        return view('tenant.invoices.index', compact('invoices', 'tenant'));
    }

    public function download(Invoice $invoice)
    {
        // Make sure this invoice belongs to current tenant
        abort_if($invoice->tenant_id !== Auth::user()->tenant->id, 403);
        $invoice->load(['tenant.user', 'tenant.room.property']);
        $pdf = Pdf::loadView('admin.invoices.pdf', compact('invoice'));
        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }
}