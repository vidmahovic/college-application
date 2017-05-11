<?php

namespace App\Transformers;
use App\Models\Application;
use Illuminate\Contracts\Support\Arrayable;
use League\Fractal;

/**
 * Class NullTransformer
 *
 * @package \App\Transformers
 */
class ApplicationTemplateTransformer extends Fractal\TransformerAbstract
{
    protected $defaultIncludes = ['user'];


    public function transform(Application $application)
    {
        return [
            'emso' => $application->emso,
            'gender' => $application->gender,
            'date_of_birth' => $application->date_of_birth,
            'phone' => $application->phone,
            'country_id' => $application->country_id,
            'citizen_id' => $application->citizen_id,
            'district_id' => $application->district_id,
            'middle_school_id' => $application->middle_school_id,
            'profession_id' => $application->profession_id,
            'education_type_id' => $application->education_type_id,
            'graduation_type_id' => $application->graduation_type_id,
            'permanent_address' => $application->permanent_address,
            'mailing_address' => $application->mailing_address,
            'permanent_country_id' => $application->permanent_country_id,
            'mailing_country_id' => $application->mailing_country_id,
            'permanent_applications_cities_id' => $application->permanent_applications_cities_id,
            'mailing_applications_cities_id' => $application->mailing_applications_cities_id,
            'wishes' => $application->wishes
        ];
    }

    public function includeUser($item) {
        return $this->item($item->user, new UserTransformer);
    }
}
