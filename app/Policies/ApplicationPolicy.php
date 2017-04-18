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

    public function before(User $user, $ability) {
        return $user->isAdmin();
    }

    public function get(User $user)
    {
        return $user->isStaff();
    }

    public function paginate(User $user)
    {
        return $this->get($user);
    }

    public function view(User $user, Application $application)
    {
        return $user->isStaff() || $application->user_id === $user->id;
    }

    public function viewActive(User $user)
    {
        return $user->isStudent();
    }

    public function update(User $user, Application $application)
    {
        return $user->isStaff() || $application->user_id === $user->id;
    }

    public function archive(User $user, Application $application)
    {
        return $user->isStaff() || $application->user_id === $user->id;
    }

    public function delete(User $user)
    {
        return $user->isStaff();
    }
}