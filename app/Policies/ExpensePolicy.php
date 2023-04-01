<?php

namespace App\Policies;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExpensePolicy
{
    public function show(User $user, Expense $expense)
    {
        return $user->id === $expense->id_user
            ? Response::allow()
            : Response::deny('You do not have permission to view this expense.');
    }

    public function update(User $user, Expense $expense)
    {
        return $user->id === $expense->id_user
            ? Response::allow()
            : Response::deny('You do not have permission to edit this expense.');
    }

    public function destroy(User $user, Expense $expense)
    {
        return $user->id === $expense->id_user
            ? Response::allow()
            : Response::deny('You do not have permission to delete this expense.');
    }
}
