<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Facility;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RoomFacilityController extends Controller
{
    /**
     * View all the facilities in a room
     */
    public function index(Room $room, Request $request): Factory|View
    {
        $search = $request->query('search');

        $facilities = $room->facilities()->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })->orderBy('name')->paginate(10)->withQueryString();

        return view('room.facility.index', compact('room', 'facilities'));
    }

    /**
     * Form to add facilities to the room
     */
    public function create(Room $room): Factory|View
    {
        // Take the facilities that the room does NOT have
        $availableFacilities = Facility::whereNotIn('id',
            $room->facilities()->pluck('facilities.id'))->orderBy('name')->get();

        return view('room.facility.create', compact('room', 'availableFacilities'));
    }

    /**
     * Save room-facility relationship (attach)
     */
    public function store(Request $request, Room $room): RedirectResponse
    {
        $validated = $request->validate([
            'facility_ids'   => 'required|array|min:1',
            'facility_ids.*' => 'exists:facilities,id',
        ]);

        $room->facilities()->attach($validated['facility_ids']);

        return redirect()->route('rooms.facilities.index', $room)->with('success',
            'Facility successfully added to room.');
    }

    /**
     * Remove facilities from the room (detach)
     */
    public function destroy(Room $room, Facility $facility): RedirectResponse
    {
        $room->facilities()->detach($facility->id);

        return redirect()->route('rooms.facilities.index', $room)->with('success',
            'Facility successfully removed from room.');
    }
}
