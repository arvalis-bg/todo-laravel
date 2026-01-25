<?php

namespace App\Policies;

use App\Models\Todo;
use App\Models\User;

class TodoPolicy
{
    /**
     * Check if the user can view any todos.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Check if the user can view exact todo.
     */
    public function view(User $user, Todo $todo): bool
    {
        return $todo->user_id === $user->id;
    }

    /**
     * Check if the user can create todos.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Check if the user can update exact todo.
     */
    public function update(User $user, Todo $todo): bool
    {
        return $todo->user_id === $user->id;
    }

    /**
     * Check if the user can delete exact todo.
     */
    public function delete(User $user, Todo $todo): bool
    {
        return $todo->user_id === $user->id;
    }

    /**
     * Check if the user can toggle completion of exact todo.
     */
    public function toggle(User $user, Todo $todo): bool
    {
        return $todo->user_id === $user->id;
    }
}