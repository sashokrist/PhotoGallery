<?php
// app/Policies/PhotoPolicy.php

namespace App\Policies;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PhotoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the photo.
     *
     * @param User $user
     * @param Photo $photo
     * @return bool
     */
    public function view(User $user, Photo $photo)
    {
        // Only allow the owner of the photo or an admin to view the photo
        return $user->id === $photo->user_id || $user->isAdmin;
    }

    /**
     * Determine whether the user can create photos.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        // Only allow authenticated users to create photos
        return $user->id !== null;
    }

    /**
     * Determine whether the user can update the photo.
     *
     * @param User $user
     * @param Photo $photo
     * @return bool
     */
    public function update(User $user, Photo $photo)
    {
        // Only allow the owner of the photo or an admin to update the photo
        return $user->id === $photo->user_id || $user->isAdmin;
    }

    /**
     * Determine whether the user can delete the photo.
     *
     * @param User $user
     * @param Photo $photo
     * @return bool
     */
    public function delete(User $user, Photo $photo)
    {
        // Only allow the owner of the photo or an admin to delete the photo
        return $user->id === $photo->user_id || $user->isAdmin;
    }
}
