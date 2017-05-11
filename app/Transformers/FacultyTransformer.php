<?php

namespace App\Transformers;

use App\Models\Faculty;
use League\Fractal;

/**
 * Class FacultyTransformer
 *
 * @package \App\Transformers
 */
class FacultyTransformer extends Fractal\TransformerAbstract
{

    protected $defaultIncludes = ['district', 'university'];

    public function transform(Faculty $faculty)
    {
        return [
            'id' => $faculty->id,
            'name' => $faculty->name,
            'acronym' => $faculty->acronym
        ];
    }

    public function includeDistrict(Faculty $faculty)
    {
        return $this->item($faculty->district, new DistrictTransformer);
    }

    public function includeUniversity(Faculty $faculty)
    {
        return $this->item($faculty->university, new UniversityTransformer);
    }


}
