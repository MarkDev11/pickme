<?php

namespace App\Policies;

use App\Models\GrowthRecord;
use App\Models\User;

class GrowthRecordPolicy
{
    /**
     * Determine whether the user can view the growth record.
     */
    public function view(User $user, GrowthRecord $record): bool
    {
        return $user->id === $record->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the growth record.
     */
    public function update(User $user, GrowthRecord $record): bool
    {
        return $user->id === $record->user_id;
    }

    /**
     * Determine whether the user can delete the growth record.
     */
    public function delete(User $user, GrowthRecord $record): bool
    {
        return $user->id === $record->user_id;
    }
}
