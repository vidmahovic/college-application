<?php

namespace App\Transfomers;

use App\Models\FacultyProgram;
use League\Fractal;

class FacultyProgramTransformer extends Fractal\TransformerAbstract
{
	public function transform(FacultyProgram $program)
	{
	    return [
	        'name'		=> (string) $program->name,
	        'type'		=> (int) $program->type,
	        'is_regular'		=> (boolean) $program->is_regular,
	        'min_points'		=> (int) $program->min_points
	}
}