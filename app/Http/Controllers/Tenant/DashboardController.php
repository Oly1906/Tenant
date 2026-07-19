<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $tenant = Auth::user()->tenant;
        $tenant->load(['room.property', 'invoices', 'utilityRecords']);

        $pendingInvoice    = $tenant->invoices()->where('status', 'pending')->latest()->first();
        $latestUtility     = $tenant->utilityRecords()->latest('month')->first();
        $recentInvoices    = $tenant->invoices()->latest()->take(5)->get();
        $announcements     = \App\Models\Announcement::latest()->take(3)->get();

        return view('tenant.dashboard', compact(
            'tenant', 'pendingInvoice', 'latestUtility', 'recentInvoices', 'announcements'
        ));
    }
}