<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ContractController extends Controller
{
    public function index()
    {
        $tenant = Auth::user()->tenant;
        $tenant->load(['user', 'room.property']);
        return view('tenant.contracts.index', compact('tenant'));
    }

    public function download()
    {
        $tenant = Auth::user()->tenant;
        $tenant->load(['user', 'room.property']);
        $pdf = Pdf::loadView('tenant.contracts.pdf', compact('tenant'));
        return $pdf->download('lease-contract.pdf');
    }
}