<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PostPolicy
{

    use HandlesAuthorization;
    public function before(User $user)
    {
        // If the user is an admin, they can do anything
        if ($user->hasRole('admin')) {
            return true;
        }
    }


    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->author_id;
    }


    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->author_id;
    }


}
