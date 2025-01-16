<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return RoomResource::collection(
            Room::with(['structure', 'country', 'photos', 'materials'])->paginate()
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
    public function store(StoreRoomRequest $request)
    {
        $room = Room::create($request->validated());
        
        if (isset($request->validated()['materials'])) {
            $room->materials()->sync($request->validated()['materials']);
        }
        return RoomResource::make($room->load(['structure', 'country', 'photos', 'materials']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return RoomResource::make($room->load(['structure', 'country', 'photos', 'materials']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $this->authorize('update', $room);
        
        $room->update($request->validated());

        if (isset($validated['materials'])) {
            $room->materials()->sync($request->validated()['materials']);
        }
    
        return RoomResource::make($room->load(['structure', 'country', 'photos', 'materials']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room): Response
    {
        $this->authorize('delete', $room);

        $room->delete();

        return response()->noContent();
    }
}
