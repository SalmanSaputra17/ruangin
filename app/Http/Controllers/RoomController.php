<?php

namespace App\Http\Controllers;

use App\Http\Requests\Room\StoreOrUpdateRoomRequest;
use App\Models\Room;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Factory|View
    {
        $query = Room::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $rooms = $query->paginate(10);

        return view('room.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Factory|View
    {
        return view('room.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrUpdateRoomRequest $request): RedirectResponse
    {
        $input = $request->validated();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;

        Room::create($input);

        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room): Factory|View
    {
        return view('room.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOrUpdateRoomRequest $request, Room $room): RedirectResponse
    {
        $input = $request->validated();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;

        $room->update($input);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room): RedirectResponse
    {
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }
}
