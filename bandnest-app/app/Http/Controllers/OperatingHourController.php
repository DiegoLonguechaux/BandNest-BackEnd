<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOperatingHourRequest;
use App\Http\Requests\UpdateOperatingHourRequest;
use App\Http\Resources\OperatingHourResource;
use App\Models\OperatingHour;
use Illuminate\Http\Request;

class OperatingHourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return OperatingHourResource::collection( OperatingHour::with('room')->paginate());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOperatingHourRequest $request)
    {
        $this->authorize('create', OperatingHour::class);

        $validated = $request->validated();

        $operatingHour = OperatingHour::create($validated);

        return OperatingHourResource::make($operatingHour->load('room'));    
    }

    /**
     * Display the specified resource.
     */
    public function show(OperatingHour $operatingHour)
    {
        return OperatingHourResource::make($operatingHour->load('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OperatingHour $operatingHour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOperatingHourRequest $request, OperatingHour $operatingHour)
    {
        $this->authorize('update', $operatingHour);

        $validated = $request->validated();

        $operatingHour->update($validated);

        return OperatingHourResource::make($operatingHour->load('room'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OperatingHour $operatingHour)
    {
        $this->authorize('delete', $operatingHour);

        $operatingHour->delete();

        return response()->noContent();
    }
}
