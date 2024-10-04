<?php

namespace App\Policies;

use App\Models\Structure;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StructurePolicy
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
    public function view(User $user, Structure $structure)
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
    public function update(User $user, Structure $structure)
    {
        return $user->hasRole('super_admin') || $user->id === $structure->owner_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Structure $structure)
    {
        return $user->hasRole('super_admin') || $user->id === $structure->owner_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Structure $structure)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Structure $structure)
    {
        //
    }
}
