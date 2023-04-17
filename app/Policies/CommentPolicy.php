<?php

namespace App\Policies;

use App\Models\User;

class CommentPolicy
{

    /**
     * Determine whether the user can store a comment.
     *
     * @param User $user
     * @return bool
     */
    public function store(User $user)
    {
        // Only logged-in users can store comments
        return !is_null($user);
    }
}
