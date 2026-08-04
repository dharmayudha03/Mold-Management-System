<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FormMjo;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormMjoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_form::mjo');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FormMjo $formMjo): bool
    {
        return $user->can('view_form::mjo');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_form::mjo');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FormMjo $formMjo): bool
    {
        return $user->can('update_form::mjo');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FormMjo $formMjo): bool
    {
        return $user->can('delete_form::mjo');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_form::mjo');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, FormMjo $formMjo): bool
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
    public function restore(User $user, FormMjo $formMjo): bool
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
    public function replicate(User $user, FormMjo $formMjo): bool
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
