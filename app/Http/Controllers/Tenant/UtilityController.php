<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UtilityController extends Controller
{
    public function index()
    {
        $tenant  = Auth::user()->tenant;
        $records = $tenant->utilityRecords()->orderByDesc('month')->paginate(12);
        return view('tenant.utilities.index', compact('tenant', 'records'));
    }
}