<?php

namespace App\Policies;

use App\Models\Application;
use App\User;

/**
 * Class ApplicationPolicy
 *
 * @package \App\Policies
 */
class ApplicationPolicy
{
    public function before(User $user)
    {
        if($user->isAdmin()) return true;
    }

    public function get(User $user)
    {
        return $user->isEnrollmentService() || $user->isReferent();
    }

    public function paginate(User $user)
    {
        return $this->get($user);
    }

    public function view(User $user, Application $application)
    {
        return $user->isReferent() || $application->user_id === $user->id;
    }

    public function viewActive(User $user)
    {
        return $user->isStudent();
    }

    public function create(User $user)
    {
        return $user->isStudent() || $user->isReferent();
    }

    public function update(User $user, Application $application)
    {
        return $user->isReferent() || $application->user_id === $user->id;
    }

    public function archive(User $user, Application $application)
    {
        return $user->isReferent() || $application->user_id === $user->id;
    }

    public function delete(User $user)
    {
        return $user->isReferent();
    }
}
