<?php

namespace App\Policies;

use App\Models\Child;
use App\Models\User;

class ChildPolicy
{
    /**
     * Determine whether the user can view the child.
     */
    public function view(User $user, Child $child): bool
    {
        return $user->id === $child->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the child.
     */
    public function update(User $user, Child $child): bool
    {
        return $user->id === $child->user_id;
    }

    /**
     * Determine whether the user can delete the child.
     */
    public function delete(User $user, Child $child): bool
    {
        return $user->id === $child->user_id;
    }
}
