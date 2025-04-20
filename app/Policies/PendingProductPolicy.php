<?php

namespace App\Policies;

use App\Models\PendingProduct;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PendingProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole('admin', 'mod');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PendingProduct $pendingProduct): bool
    {
        return $user->hasAnyRole('admin', 'mod');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole('admin', 'mod');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PendingProduct $pendingProduct): bool
    {
        return $user->hasAnyRole('admin', 'mod');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PendingProduct $pendingProduct): bool
    {
        return $user->hasAnyRole('admin', 'mod');
    }

    public function deleteAny(User $user, PendingProduct $pendingProduct): bool
    {
        return $user->hasAnyRole('admin', 'mod');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PendingProduct $pendingProduct): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PendingProduct $pendingProduct): bool
    {
        return false;
    }
}
