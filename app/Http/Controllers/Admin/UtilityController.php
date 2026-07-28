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

    protected function rules(): array
    {
        return [
            'tenant_id'         => 'required|exists:tenants,id',
            'month'             => 'required|string|max:20', // e.g. "Jul 2024"
            'electricity_old'   => 'required|numeric|min:0',
            'electricity_new'   => 'required|numeric|gte:electricity_old',
            'electricity_rate'  => 'required|numeric|min:0',
            'water_old'         => 'required|numeric|min:0',
            'water_new'         => 'required|numeric|gte:water_old',
            'water_rate'        => 'required|numeric|min:0',
        ];
    }

    /**
     * គណនាកម្រិតប្រើប្រាស់ (usage) និងថ្លៃ (cost) ពីលេខរាប់ ចាស់/ថ្មី
     */
    protected function computeCosts(array $data): array
    {
        $electricityUsage = $data['electricity_new'] - $data['electricity_old'];
        $waterUsage        = $data['water_new'] - $data['water_old'];

        $electricityCost = $electricityUsage * $data['electricity_rate'];
        $waterCost        = $waterUsage * $data['water_rate'];

        return [
            'electricity_old'   => $data['electricity_old'],
            'electricity_new'   => $data['electricity_new'],
            'electricity_rate'  => $data['electricity_rate'],
            'electricity_usage' => $electricityUsage,
            'electricity_cost'  => $electricityCost,

            'water_old'    => $data['water_old'],
            'water_new'    => $data['water_new'],
            'water_rate'   => $data['water_rate'],
            'water_usage'  => $waterUsage,
            'water_cost'   => $waterCost,

            'total_cost'   => $electricityCost + $waterCost,
        ];
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        UtilityRecord::updateOrCreate(
            [
                'tenant_id' => $data['tenant_id'],
                'month'     => $data['month'],
            ],
            $this->computeCosts($data)
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
        $rules = $this->rules();
        unset($rules['tenant_id']); // មិនអនុញ្ញាតឲ្យប្តូរអ្នកជួលពេល edit

        $data = $request->validate($rules);

        $utility->update($this->computeCosts($data) + ['month' => $data['month']]);

        return redirect()->route('admin.utilities.index')
            ->with('success', 'Utility updated.');
    }

    public function destroy(UtilityRecord $utility)
    {
        $utility->delete();
        return back()->with('success', 'Utility record deleted.');
    }
    public function preview(Request $request)
    {
        $utility = UtilityRecord::where('tenant_id', $request->tenant_id)
            ->where('month', $request->month)
            ->first();

        if (!$utility) {
            return response()->json([
                'error' => 'រកមិនឃើញ Utility Record សម្រាប់ខែនេះ — សូម Add Utility ជាមុន'
            ]);
        }

        return response()->json($utility);
    }

}