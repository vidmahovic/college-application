<?php

namespace App\Validators;

use Illuminate\Http\Request;


/**
 * Class Validator
 *
 * @package \App\Validators
 */
abstract class Validator
{

    protected $errors = [];

    public function validate(Request $request)
    {

    }

    public function errors()
    {
        return $this->errors;
    }

    protected function getValidatorInstance()
    {
        return app('validator');
    }

}
