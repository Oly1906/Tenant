<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Room, Property};
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with(['property', 'tenant.user'])->paginate(20);
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $properties = Property::all();
        return view('admin.rooms.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'number'      => 'required|string',
            'type'        => 'required|string',
            'floor'       => 'nullable|string',
            'size'        => 'nullable|numeric',
            'price'       => 'required|numeric|min:0',
        ]);
        Room::create($data);
        return redirect()->route('admin.rooms.index')->with('success', 'Room created.');
    }

    public function edit(Room $room)
    {
        $properties = Property::all();
        return view('admin.rooms.edit', compact('room', 'properties'));
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'number' => 'required|string',
            'type'   => 'required|string',
            'floor'  => 'nullable|string',
            'size'   => 'nullable|numeric',
            'price'  => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied',
        ]);
        $room->update($data);
        return redirect()->route('admin.rooms.index')->with('success', 'Room updated.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted.');
    }
}