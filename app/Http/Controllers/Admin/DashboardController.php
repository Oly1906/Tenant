<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Room, Tenant, Invoice, Announcement};

class DashboardController extends Controller
{
    public function index()
    {
        $totalRooms     = Room::count();
        $occupiedRooms  = Room::where('status', 'occupied')->count();
        $availableRooms = Room::where('status', 'available')->count();
        $monthlyIncome  = Invoice::where('status', 'paid')
            ->whereMonth('month', now()->month)
            ->sum('total');
        $outstanding = Invoice::where('status', 'pending')->sum('total');
        $recentTenants   = Tenant::with(['user', 'room'])->latest()->take(5)->get();
        $recentInvoices  = Invoice::with(['tenant.user', 'tenant.room'])->latest()->take(5)->get();
        $announcements   = Announcement::latest()->take(3)->get();

        return view('admin.dashboard', compact(
            'totalRooms', 'occupiedRooms', 'availableRooms',
            'monthlyIncome', 'outstanding',
            'recentTenants', 'recentInvoices', 'announcements'
        ));
    }
}