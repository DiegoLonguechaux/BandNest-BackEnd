<?php

namespace App\Policies;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PhotoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Photo $photo)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->hasAnyRole(['super_admin', 'owner']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Photo $photo)
    {
        return $user->hasRole('super_admin') || $user->id === $photo->structure_id->owner_id || $user->id === $photo->room_id->structure_id->owner_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Photo $photo)
    {
        return $user->hasRole('super_admin') || $user->id === $photo->structure_id->owner_id || $user->id === $photo->room_id->structure_id->owner_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Photo $photo)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Photo $photo)
    {
        //
    }
}
