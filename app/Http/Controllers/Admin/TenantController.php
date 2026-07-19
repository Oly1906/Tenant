<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Tenant, User, Room};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::with(['user', 'room.property'])
            ->where('status', 'active')->paginate(20);
        return view('admin.tenants.index', compact('tenants'));
    }

    public function create()
    {
        $rooms = Room::where('status', 'available')->get();
        return view('admin.tenants.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:6',
            'phone'       => 'nullable|string',
            'room_id'     => 'required|exists:rooms,id',
            'lease_start' => 'required|date',
            'lease_end'   => 'required|date|after:lease_start',
            'deposit'     => 'nullable|numeric|min:0',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'role'     => 'tenant',
        ]);

        Tenant::create([
            'user_id'     => $user->id,
            'room_id'     => $request->room_id,
            'lease_start' => $request->lease_start,
            'lease_end'   => $request->lease_end,
            'deposit'     => $request->deposit ?? 0,
        ]);

        Room::find($request->room_id)->update(['status' => 'occupied']);

        return redirect()->route('admin.tenants.index')->with('success', 'Tenant created.');
    }

    public function show(Tenant $tenant)
    {
        $tenant->load(['user', 'room.property', 'invoices', 'utilityRecords']);
        return view('admin.tenants.show', compact('tenant'));
    }

    public function edit(Tenant $tenant)
    {
        $rooms = Room::where('status', 'available')
            ->orWhere('id', $tenant->room_id)->get();
        return view('admin.tenants.edit', compact('tenant', 'rooms'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'phone'       => 'nullable|string',
            'lease_start' => 'required|date',
            'lease_end'   => 'required|date|after:lease_start',
            'deposit'     => 'nullable|numeric|min:0',
        ]);

        $tenant->user->update([
            'name'  => $request->name,
            'phone' => $request->phone,
        ]);

        $tenant->update([
            'lease_start' => $request->lease_start,
            'lease_end'   => $request->lease_end,
            'deposit'     => $request->deposit ?? 0,
        ]);

        return redirect()->route('admin.tenants.index')->with('success', 'Tenant updated.');
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->room->update(['status' => 'available']);
        $tenant->update(['status' => 'inactive']);
        return redirect()->route('admin.tenants.index')->with('success', 'Tenant deactivated.');
    }
}