<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    public function view(User $user, Task $task)
    {
        // Admin or the creator or assigned User can View tasks
        return $user->role === 'admin'
            || $task->assigned_to === $user->id
            || $task->created_by === $user->id;
    }

    public function update(User $user, Task $task)
    {
        // Admin or the creator can update task details
        return $user->role === 'admin' || $task->created_by === $user->id;
    }

    public function changeStatus(User $user, Task $task)
    {
        // Admin or assigned user can change task status
        return $user->role === 'admin' || $task->assigned_to === $user->id;
    }

    public function assign(User $user, Task $task)
    {
        // only admin can assign
        return $user->role === 'admin';
    }

    public function delete(User $user, Task $task)
    {
        // Admin or the creator can delete task
        return $user->role === 'admin' || $task->created_by === $user->id;
    }
}
