<?php

namespace App\Transfomers;

use App\Models\FacultyProgram;
use League\Fractal;

class FacultyProgramTransformer extends Fractal\TransformerAbstract
{

	protected $availableIncludes = [
        'faculty'
    ];

	public function transform(FacultyProgram $program)
	{
	    return [
	    	'id'		=> (string) $program->id,
	        'name'		=> (string) $program->name,
	        'type'		=> (int) $program->type,
	        'faculty_id'		=> (int) $program->faculty_id,
	        'allow_double_degree'		=> (boolean) $program->allow_double_degree,
	        'is_regular'		=> (boolean) $program->is_regular,
	        'min_points'		=> (int) $program->min_points
	}

	// TODO count(), countAll() methods

	public function includeFaculty(FacultyProgram $program)
    {
        $faculty = $program->faculty;

        return $this->item($faculty, new FacultyTransformer);
    }
}