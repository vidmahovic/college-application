<?php

namespace App\Transformers;

use App\Models\Application;
use League\Fractal;

/**
 * Class ApplicationTransformer
 *
 * @package \App\Transformers
 */
class ApplicationTransformer extends Fractal\TransformerAbstract
{

    protected $defaultIncludes = [
        'citizen', 'interval', 'middle_school', 'nationality', 'education', 'profession', 'applicant', 'graduation'
    ];

    public function transform(Application $application)
    {
        return [
            'id' => $application->id,
            'middle_name' => $application->middle_name,
            'gender' => $application->gender,
            'emso' => $application->emso,
            'date_of_birth' => $application->date_of_birth,
            'status' => $application->status,
        ];
    }

    public function includeCitizen(Application $application) {
        return $this->item($application->citizen, new CitizenTransformer);
    }

    public function includeInterval(Application $application) {
        return $this->item($application->interval, new ApplicationIntervalTransformer);
    }

    public function includeMiddleSchool(Application $application) {
        return $this->item($application->middleSchool, new MiddleSchoolTransformer);
    }

    public function includeNationality(Application $application) {
        return $this->item($application->nationality, new NationalityTypeTransformer);
    }

    public function includeEducation(Application $application) {
        return $this->item($application->education, new EducationTypeTransformer);
    }

    public function includeProfession(Application $application) {
        return $this->item($application->profession, new ProfessionTransformer);
    }

    public function includeCountry(Application $application) {
        return $this->item($application->country, new CountryTransformer);
    }

    public function includeApplicant(Application $application) {
        return $this->item($application->applicant, new UserTransformer);
    }

    public function includeGraduation(Application $application) {
        return $this->item($application->graduation, new GraduationTypeTransformer);
    }



}