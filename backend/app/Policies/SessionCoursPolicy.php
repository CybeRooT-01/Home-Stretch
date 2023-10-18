<?php

namespace App\Policies;

use App\Models\SessionCours;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SessionCoursPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SessionCours $sessionCours): bool
    {
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role_id === 1;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SessionCours $sessionCours): bool
    {
        //uniquement pour les user avec le role_id = 4
        return $user->role_id === 4;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SessionCours $sessionCours): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SessionCours $sessionCours): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SessionCours $sessionCours): bool
    {
        //
    }
}
