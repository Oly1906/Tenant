<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $tenant = $user->tenant;
        return view('tenant.profile', compact('user', 'tenant'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name'              => 'required|string|max:255',
            'phone'             => 'nullable|string|max:20',
            'emergency_contact' => 'nullable|string|max:255',
            'password'          => 'nullable|min:6|confirmed',
        ]);

        $user->update([
            'name'              => $request->name,
            'phone'             => $request->phone,
            'emergency_contact' => $request->emergency_contact,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('success', 'Profile updated.');
    }
}