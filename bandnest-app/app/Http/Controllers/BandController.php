<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBandRequest;
use App\Http\Requests\UpdateBandRequest;
use App\Http\Resources\BandResource;
use App\Models\Band;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BandResource::collection(Band::with(['genres', 'users'])->paginate());
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
    public function store(StoreBandRequest $request)
    {
        $validated = $request->validated();

        $band = Band::create($validated);

        if (isset($validated['genres'])) {
            $band->genres()->sync($validated['genres']);
        }

        if (isset($validated['users'])) {
            $band->users()->sync($validated['users']);
        }

        return BandResource::make($band->load(['genres', 'users']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Band $band)
    {
        return BandResource::make($band->load(['genres', 'users']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Band $band)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBandRequest $request, Band $band)
    {
        $this->authorize('update', $band);

        $validated = $request->validated();

        // Mettre à jour le groupe
        $band->update($validated);

        // Synchroniser les relations si nécessaires
        if (isset($validated['genres'])) {
            $band->genres()->sync($validated['genres']);
        }

        if (isset($validated['users'])) {
            $band->users()->sync($validated['users']);
        }

        return BandResource::make($band->load(['genres', 'users']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Band $band):  Response
    {
        $this->authorize('delete', $band);

        $band->delete();

        return response()->noContent();
    }
}
