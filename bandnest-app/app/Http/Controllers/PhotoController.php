<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\UpdatePhotoRequest;
use App\Http\Resources\PhotoResource;
use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PhotoResource::collection(Photo::with(['room', 'structure'])->paginate());
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
    public function store(StorePhotoRequest $request)
    {
        $validated = $request->validated();

        // Créer une photo
        $photo = Photo::create($validated);

        return PhotoResource::make($photo->load(['room', 'structure']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photo)
    {
        return PhotoResource::make($photo->load(['room', 'structure']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePhotoRequest $request, Photo $photo)
    {
        $this->authorize('update', $photo);

        $validated = $request->validated();

        // Mettre à jour la photo
        $photo->update($validated);

        return PhotoResource::make($photo->load(['room', 'structure']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photo $photo)
    {
        $this->authorize('delete', $photo);

        $photo->delete();

        return response()->noContent();
    }
}
