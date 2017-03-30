<?php

namespace CollegeApplication\Authentication;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;

trait AuthenticatesUsers
{
    use ProvidesConvenienceMethods;

    protected $username = 'email';

    public function username() {
        return $this->username;
    }

    protected  function validateLoginParams(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required',
            'password' => 'required|min:8'
        ]);
    }

    protected function validateRegisterParams(Request $request)
    {
        $this->validate($request, [
           // TODO (Vid): Set registration rules.
        ]);
    }

}
