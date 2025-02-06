<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStructureRequest;
use App\Http\Requests\UpdateStructureRequest;
use App\Http\Resources\StructureResource;
use App\Models\Structure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StructureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return StructureResource::collection(
            Structure::with(['owner', 'rooms', 'photos'])->paginate()
        );
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
    public function store(StoreStructureRequest $request)
    {
        $this->authorize('create', Structure::class);
        
        $structure = Structure::create($request->validated());

        return StructureResource::make($structure->load(['owner', 'rooms', 'photos']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Structure $structure)
    {
        return StructureResource::make($structure->load(['owner', 'rooms', 'photos']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Structure $structure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStructureRequest $request, Structure $structure)
    {
        $this->authorize('update', $structure);

        $structure->update($request->validated());

        return StructureResource::make($structure->load(['owner', 'rooms', 'photos']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Structure $structure): Response
    {
        $this->authorize('delete', $structure);

        $structure->delete();

        return response()->noContent();
    }
}
