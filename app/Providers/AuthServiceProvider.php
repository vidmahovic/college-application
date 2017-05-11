<?php

namespace App\Providers;

use App\Models\Application;
use App\Models\FacultyProgram;
use App\Policies\ApplicationPolicy;
use App\Policies\FacultyProgramPolicy;
use App\User;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->input('api_token')) {
                return User::where('api_token', $request->input('api_token'))->first();
            }
        });

        // Define Policies
        $gate = $this->app[Gate::class];
        $gate->policy(Application::class, ApplicationPolicy::class);
        $gate->policy(FacultyProgram::class, FacultyProgramPolicy::class);
    }
}
