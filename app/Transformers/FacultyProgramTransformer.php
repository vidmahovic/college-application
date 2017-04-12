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
    public function transform(FacultyProgram $program) {
        return [
            'id' => $program->id,
            'faculty_id' => $program->faculty_id,
            'name' => $program->name,
            'is_regular' => $program->is_regular,
            'min_points' => $program->min_points,
            'type' => $program->type,
            'allow_double_degree' => $program->allow_double_degree,
        ];
    }
}