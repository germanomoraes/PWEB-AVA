<?php

namespace App\Policies;

use App\Models\Nota;
use App\Models\User;

class NotaPolicy
{
    // Verifica se a nota pertence ao usuário
    public function view(User $user, Nota $nota): bool {
        return $user->id === $nota->user_id;
    }

    public function update(User $user, Nota $nota): bool {
        return $user->id === $nota->user_id;
    }

    public function delete(User $user, Nota $nota): bool {
        return $user->id === $nota->user_id;
    }

    public function restore(User $user, Nota $nota): bool {
        return $user->id === $nota->user_id;
    }

    public function forceDelete(User $user, Nota $nota): bool {
        return $user->id === $nota->user_id;
    }
}
