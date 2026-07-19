<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['tenant.user', 'tenant.room'])
            ->latest()->paginate(20);

        $totalCollected = Invoice::where('status', 'paid')
            ->whereMonth('month', now()->month)->sum('total');
        $outstanding = Invoice::where('status', 'pending')->sum('total');

        return view('admin.payments.index', compact('invoices', 'totalCollected', 'outstanding'));
    }
}