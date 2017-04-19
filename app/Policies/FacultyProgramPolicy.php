<?php

namespace App\Policies;

use App\Models\FacultyProgram;
use App\User;

/**
 * Class FacultyProgramPolicy
 *
 * @package \App\Policies
 */
class FacultyProgramPolicy
{

    public function before(User $user, $ability)
    {
        if($user->isAdmin()) return true;
    }

    public function view(User $user, FacultyProgram $program)
    {
        return true;
    }

    public function get(User $user)
    {
        return true;
    }

    public function paginate(User $user)
    {
        return true;
    }

    public function update(User $user)
    {
        // TODO (Vid): only referent, connected to specific faculty can update it's program
        return $user->isReferent();
    }

    public function delete(User $user) {
        return $user->isReferent();
    }
}
