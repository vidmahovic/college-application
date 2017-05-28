<?php
namespace App\Transformers;

use App\Models\FacultyProgram;
use League\Fractal;
/**
 * Class FacultyProgramTransformer
 *
 * @package \\${NAMESPACE}
 */
class FacultyProgramTransformer extends Fractal\TransformerAbstract
{

    protected $defaultIncludes = ['faculty', 'enrollmentConditions'];

    public function transform(FacultyProgram $program) {
        return [
            'id' => $program->id,
            'faculty_id' => $program->faculty_id,
            'name' => $program->name,
            'is_regular' => $program->is_regular,
            'min_points' => $program->min_points,
            'type' => $program->type,
            'allow_double_degree' => $program->allow_double_degree,
            'max_accepted' => $program->max_accepted,
            'max_accepted_foreiqn' => $program->max_accepted_foreign,
            'count_enrolled' => $program->count_enrolled,
            'count_enrolled_foreign' => $program->count_enrolled_foreign,
            'count_accepted' => $program->count_accepted,
            'count_accepted_foreign' => $program->count_accepted_foreign
        ];
    }

    public function includeFaculty(FacultyProgram $program)
    {
        return $this->item($program->faculty, new FacultyTransformer);
    }

    public function includeEnrollmentConditions(FacultyProgram $program)
    {
        return $this->collection($program->enrollmentConditions, new EnrollmentConditionTransformer);
    }
}
