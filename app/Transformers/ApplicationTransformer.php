<?php

namespace App\Transformers;

use App\Models\Application;
use App\Models\FacultyProgram;
use Illuminate\Support\Facades\App;
use League\Fractal;

/**
 * Class ApplicationTransformer
 *
 * @package \App\Transformers
 */
class ApplicationTransformer extends Fractal\TransformerAbstract
{

    protected $defaultIncludes = [
        'applicant', 'citizen', 'interval', 'middleSchool', 'education', 'profession', 'graduation',
        'firstWish', 'secondWish', 'thirdWish', 'permanentAddress', 'mailingAddress', 'permanentCountry',
        'mailingCountry'
    ];

    public function transform(Application $application)
    {
        return [
            'id' => $application->id,
            'phone' => $application->phone,
            'gender' => $application->gender,
            'emso' => $application->emso,
            'date_of_birth' => $application->date_of_birth,
            'status' => $application->status,
        ];
    }

    public function includePermanentAddress(Application $application) {
        if(($permanentAddress = $application->permanentAddress->first()) != null)
            return $this->item($permanentAddress, new CityTransformer)->setMetaValue('address', $permanentAddress->pivot->address);
    }

    public function includeMailingAddress(Application $application) {
        if(($mailingAddress = $application->mailingAddress->first()) != null)
            return $this->item($mailingAddress, new CityTransformer)->setMetaValue('address', $mailingAddress->pivot->address);
    }

    public function includeFirstWish(Application $application) {
        if(($firstWish = $application->firstWish) != null)
            // return $this->item($firstWish, new FacultyProgramTransformer)->setMetaValue('accepted', $firstWish->pivot->status);
            return $this->collection($firstWish, new FacultyProgramTransformer);
    }

    public function includeSecondWish(Application $application) {
        if(($secondWish = $application->secondWish) != null)
            return $this->collection($secondWish, new FacultyProgramTransformer);
    }

    public function includeThirdWish(Application $application) {
        if(($thirdWish = $application->thirdWish) != null)
            return $this->collection($thirdWish, new FacultyProgramTransformer);
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

    public function includeEducation(Application $application) {
        return $this->item($application->education, new EducationTypeTransformer);
    }

    public function includeProfession(Application $application) {
        return $this->item($application->profession, new ProfessionTransformer);
    }

    public function includeApplicant(Application $application) {
        return $this->item($application->applicant, new UserTransformer);
    }

    public function includeGraduation(Application $application) {
        return $this->item($application->graduation, new GraduationTypeTransformer);
    }

    public function includePermanentCountry(Application $application) {
        if(($permanentCountry = $application->permanentCountry->first()) != null)
            return $this->item($permanentCountry, new CountryTransformer);
    }

    public function includeMailingCountry(Application $application) {
        if(($mailingCountry = $application->mailingCountry->first()) != null)
            return $this->item($mailingCountry, new CountryTransformer);
    }
}
