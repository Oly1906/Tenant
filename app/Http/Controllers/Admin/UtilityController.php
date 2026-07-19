<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{UtilityRecord, Tenant};
use Illuminate\Http\Request;

class UtilityController extends Controller
{
    public function index()
    {
        $records = UtilityRecord::with(['tenant.user', 'tenant.room'])
            ->latest()->paginate(20);
        return view('admin.utilities.index', compact('records'));
    }

    public function create()
    {
        $tenants = Tenant::with(['user', 'room'])
            ->where('status', 'active')->get();
        return view('admin.utilities.create', compact('tenants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tenant_id'        => 'required|exists:tenants,id',
            'month'            => 'required|date',
            'electricity_kwh'  => 'nullable|numeric|min:0',
            'electricity_cost' => 'nullable|numeric|min:0',
            'water_m3'         => 'nullable|numeric|min:0',
            'water_cost'       => 'nullable|numeric|min:0',
        ]);

        $total = ($request->electricity_cost ?? 0) + ($request->water_cost ?? 0);

        UtilityRecord::updateOrCreate(
            [
                'tenant_id' => $request->tenant_id,
                'month'     => $request->month,
            ],
            [
                'electricity_kwh'  => $request->electricity_kwh  ?? 0,
                'electricity_cost' => $request->electricity_cost ?? 0,
                'water_m3'         => $request->water_m3         ?? 0,
                'water_cost'       => $request->water_cost       ?? 0,
                'total_cost'       => $total,
            ]
        );

        return redirect()->route('admin.utilities.index')
            ->with('success', 'Utility record saved.');
    }

    public function edit(UtilityRecord $utility)
    {
        return view('admin.utilities.edit', ['record' => $utility]);
    }

    public function update(Request $request, UtilityRecord $utility)
    {
        $request->validate([
            'month'            => 'required|date',
            'electricity_kwh'  => 'nullable|numeric|min:0',
            'electricity_cost' => 'nullable|numeric|min:0',
            'water_m3'         => 'nullable|numeric|min:0',
            'water_cost'       => 'nullable|numeric|min:0',
        ]);

        $total = ($request->electricity_cost ?? 0) + ($request->water_cost ?? 0);

        $utility->update([
            'month'            => $request->month,
            'electricity_kwh'  => $request->electricity_kwh  ?? 0,
            'electricity_cost' => $request->electricity_cost ?? 0,
            'water_m3'         => $request->water_m3         ?? 0,
            'water_cost'       => $request->water_cost       ?? 0,
            'total_cost'       => $total,
        ]);

        return redirect()->route('admin.utilities.index')
            ->with('success', 'Utility updated.');
    }

    public function destroy(UtilityRecord $utility)
    {
        $utility->delete();
        return back()->with('success', 'Utility record deleted.');
    }
}