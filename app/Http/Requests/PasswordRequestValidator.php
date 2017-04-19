<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;


/**
 * Class PasswordRequestValidator
 *
 * @package \App\Http\Requests
 */
class PasswordRequestValidator extends FormRequest
{

    public function rules()
    {
        return [
            'old_password' => 'required',
            'new_password' => [
                'required',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$',
                'min:8'
            ]
        ];
    }

}
