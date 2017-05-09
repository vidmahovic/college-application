<?php

namespace App\Transformers;

use App\Models\Application;
use App\Models\FacultyProgram;
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
        'firstWish', 'secondWish', 'thirdWish', 'permanentAddress', 'mailingAddress'
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
        if(($firstWish = $application->firstWish->first()) != null)
            return $this->item($firstWish, new FacultyProgramTransformer)->setMetaValue('accepted', $firstWish->pivot->status);
    }

    public function includeSecondWish(Application $application) {
        if(($secondWish = $application->secondWish->first()) != null)
            return $this->item($secondWish, new FacultyProgramTransformer)->setMetaValue('accepted', $secondWish->pivot->status);
    }

    public function includeThirdWish(Application $application) {
        if(($thirdWish = $application->thirdWish->first()) != null)
            return $this->item($thirdWish, new FacultyProgramTransformer)->setMetaValue('accepted', $thirdWish->pivot->status);
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
