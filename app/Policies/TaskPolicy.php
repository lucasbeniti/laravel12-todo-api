<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Verificar se o usuário pode visualizar a task.
     */
    public function view(User $user, Task $task): bool
    {
        return $task->user_id === $user->id;
    }

    /**
     * Verificar se o usuário pode atualizar a task.
     */
    public function update(User $user, Task $task): bool
    {
        return $task->user_id === $user->id;
    }

    /**
     * Verificar se o usuário pode deletar a task.
     */
    public function delete(User $user, Task $task): bool
    {
        return $task->user_id === $user->id;
    }
}