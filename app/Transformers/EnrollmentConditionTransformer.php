<?php
namespace App\Transformers;

use App\Models\EnrollmentCondition;
use League\Fractal;

class EnrollmentConditionTransformer extends Fractal\TransformerAbstract
{

    public function transform(EnrollmentCondition $condition) {
        return [
            'id' => $condition->id,
            'faculty_program_id' => $condition->faculty_program_id,
            'name' => $condition->name,
            'type' => $condition->type,
            'conditions_subject_id' => $condition->conditions_subject_id,
            'conditions_profession_id' => $condition->conditions_profession_id,
            'weight' => $condition->weight
        ];
    }
}
