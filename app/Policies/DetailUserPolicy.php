<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DetailUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class DetailUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_detail::user');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DetailUser $detailUser): bool
    {
        return $user->can('view_detail::user');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_detail::user');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DetailUser $detailUser): bool
    {
        return $user->can('update_detail::user');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DetailUser $detailUser): bool
    {
        return $user->can('delete_detail::user');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_detail::user');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, DetailUser $detailUser): bool
    {
        return $user->can('{{ ForceDelete }}');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('{{ ForceDeleteAny }}');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, DetailUser $detailUser): bool
    {
        return $user->can('{{ Restore }}');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('{{ RestoreAny }}');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, DetailUser $detailUser): bool
    {
        return $user->can('{{ Replicate }}');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('{{ Reorder }}');
    }
}
