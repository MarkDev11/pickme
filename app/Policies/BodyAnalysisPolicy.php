<?php

namespace App\Policies;

use App\Models\BodyAnalysis;
use App\Models\User;

class BodyAnalysisPolicy
{
    /**
     * Determine whether the user can view the analysis.
     */
    public function view(User $user, BodyAnalysis $analysis): bool
    {
        return $user->id === $analysis->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the analysis.
     */
    public function update(User $user, BodyAnalysis $analysis): bool
    {
        return $user->id === $analysis->user_id;
    }

    /**
     * Determine whether the user can delete the analysis.
     */
    public function delete(User $user, BodyAnalysis $analysis): bool
    {
        return $user->id === $analysis->user_id;
    }
}
