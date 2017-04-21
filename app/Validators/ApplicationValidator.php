<?php

namespace App\Validators;

use Carbon\Carbon;

/**
 * Class ApplicationValidator
 *
 * @package \App\Validators
 */
class ApplicationValidator extends Validator
{

    protected function rules()
    {
        return [
            // Basic validations
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date|before:' . (string) Carbon::now()->subYears(14),
            'phone' => ['required', 'regex:/^\+(?:[0-9]●?){6,14}[0-9]$/'],
            'permanent_address' => 'required|alphanum',
            'mailing_address' => 'required|alphanum',

            // Validations with regards to other tables
            'address.*.address' => '',
            'address.*.city_id' => '',
            'address.*.country_id' => '',
        ];
    }

//    static $rules = [
//
//        'gender' => 'required|in:male,female',
//        'date_of_birth' => 'required|date|before:',
//        '',
//
//
//        'middle_school_id' => 'required|exists:middle_schools,id',
//        'nationality_type_id' => 'required|exists:nationality_types,id',
//        'graduation_type_id' => 'required|exists:graduation_types,id',
//        'education_type_id' => 'required|exists:education_types,id',
//        'profession_id' => 'required|exists:professions,id',
//        'country_id' => 'required|exists:countries,id',
//        'citizen_id' => 'required|exists:citizens,id',
//        'middle_name' => 'alpha|max:255',
//        'gender' => 'required|in:male,female',
//        'emso' => 'present', // must be present but can be NULL (IF AN APPLICANT IS NOT FROM SLOVENIA - see emso rules)
//        'date_of_birth' => 'required|date',
//        'status' => 'required|in:saved,filed',
//    ];

}
