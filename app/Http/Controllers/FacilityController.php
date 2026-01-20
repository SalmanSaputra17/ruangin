<?php

namespace App\Http\Controllers;

use App\Http\Requests\Facility\StoreOrUpdateFacilityRequest;
use App\Models\Facility;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Factory|View
    {
        $query = Facility::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $facilities = $query->paginate(10);

        return view('facility.index', compact('facilities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Factory|View
    {
        return view('facility.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrUpdateFacilityRequest $request)
    {
        Facility::create($request->validated());

        return redirect()->route('facilities.index')->with('success', 'Facility created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Facility $facility)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facility $facility)
    {
        return view('facility.edit', compact('facility'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOrUpdateFacilityRequest $request, Facility $facility)
    {
        $facility->update($request->validated());

        return redirect()->route('facilities.index')->with('success', 'Facility updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $facility)
    {
        $facility->delete();

        return redirect()->route('facilities.index')->with('success', 'Facility deleted successfully.');
    }
}
