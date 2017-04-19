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

    protected $defaultIncludes = ['faculty'];

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
            'count_enrolled' => $program->count_enrolled,
            'count_accepted' => $program->count_accepted,
        ];
    }

    public function includeFaculty(FacultyProgram $program)
    {
        return $this->item($program->faculty, new FacultyTransformer);
    }
}
