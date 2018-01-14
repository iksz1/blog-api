<?php

namespace App\Policies;

use App\User;
use App\Category;

class CategoryPolicy
{

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine if the given category can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Category  $cmt
     * @return bool
     */
    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Category $cat)
    {
        return false;
    }

    public function delete(User $user, Category $cat)
    {
        return false;
    }

}