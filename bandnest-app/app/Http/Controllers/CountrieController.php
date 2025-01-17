<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCountrieRequest;
use App\Http\Requests\UpdateCountrieRequest;
use App\Http\Resources\CountrieResource;
use App\Models\Countrie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CountrieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CountrieResource::collection(Countrie::with(['structures', 'rooms'])->paginate());
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
    public function store(StoreCountrieRequest $request)
    {
        $validated = $request->validated();

        $countrie = Countrie::create($validated);

        return CountrieResource::make($countrie->load(['structures', 'rooms']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Countrie $countrie)
    {
        return CountrieResource::make($countrie->load(['structures', 'rooms']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Countrie $countrie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCountrieRequest $request, Countrie $countrie)
    {
        $this->authorize('update', $countrie);

        $validated = $request->validated();

        $countrie->update($validated);

        return CountrieResource::make($countrie->load(['structures', 'rooms']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Countrie $countrie): Response
    {
        $this->authorize('delete', $countrie);

        $countrie->delete();

        return response()->noContent();
    }
}
