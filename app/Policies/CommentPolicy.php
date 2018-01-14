<?php

namespace App\Policies;

use App\User;
use App\Comment;

class CommentPolicy
{

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine if the given comment can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Comment  $cmt
     * @return bool
     */
    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Comment $cmt)
    {
        return false;
    }

    public function delete(User $user, Comment $cmt)
    {
        return false;
    }

}