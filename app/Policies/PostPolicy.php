<?php

namespace App\Policies;

use App\User;
use App\Post;

class PostPolicy
{

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function create(User $user)
    {
        return $user->role === 'writer';
    }

    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    public function delete(User $user, Post $post)
    {
        // return $user->id === $post->user_id;
        return false;
    }

    public function restore(User $user, Post $post) {
        return false;
    }
}