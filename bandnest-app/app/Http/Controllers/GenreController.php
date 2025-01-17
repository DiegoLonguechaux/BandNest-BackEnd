<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGenreRequest;
use App\Http\Requests\UpdateGenreRequest;
use App\Http\Resources\GenreResource;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return GenreResource::collection( Genre::with('bands')->paginate());
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
    public function store(StoreGenreRequest $request)
    {
        $validated = $request->validated();

        $genre = Genre::create($validated);

        return GenreResource::make($genre->load('bands'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        return GenreResource::make($genre->load('bands'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGenreRequest $request, Genre $genre)
    {
        $this->authorize('update', $genre);

        $validated = $request->validated();

        $genre->update($validated);

        return GenreResource::make($genre->load('bands'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        $this->authorize('delete', $genre);

        $genre->delete();

        return response()->noContent();
    }
}
