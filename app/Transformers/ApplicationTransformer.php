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
        'firstWish', 'secondWish', 'thirdWish', 'acceptedWish', 'mailingAddress', 'mailingCountry'
    ];

    public function transform(Application $application)
    {
        //dd($application->permanentAddress->first());
        return [
            'id' => $application->id,
            'phone' => $application->phone,
            'gender' => $application->gender,
            'emso' => $application->emso,
            'date_of_birth' => $application->date_of_birth,
            'birthCountry' => $this->item($application->countryOfBirth()->first(), new CountryTransformer)->getData(),
            'birthAddress' => $this->item($application->districtOfBirth()->first(), new DistrictTransformer)->getData(),
            'status' => $application->status,
            'permanentAddress' => $this->item($application->permanentAddress()->first(), new CityTransformer)->getData(),
            'permanentCountry' => $this->item($application->permanentCountry()->first(), new CountryTransformer)->getData()
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

    public function includeBirthAddress(Application $application) {
        return $this->item($application->districtOfBirth, new DistrictTransformer);
    }

    public function includeBirthCountry(Application $application) {
        return $this->item($application->countryOfBirth, new CountryTransformer);
    }

    public function includeFirstWish(Application $application) {
        if(count($firstWish = $application->firstWish->all()))
            // return $this->item($firstWish, new FacultyProgramTransformer)->setMetaValue('accepted', $firstWish->pivot->status);
            return $this->collection($firstWish, new FacultyProgramTransformer);
    }

    public function includeSecondWish(Application $application) {
        if(count($secondWish = $application->secondWish->all()))
            return $this->collection($secondWish, new FacultyProgramTransformer);
    }

    public function includeThirdWish(Application $application) {
        if(count($thirdWish = $application->thirdWish->all()))
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

    public function includeAcceptedWish(Application $app) {
        $accepted = $app->acceptedWish()->first();
        if($accepted !== null) {
            return $this->item($accepted, new FacultyProgramTransformer);
        }
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
