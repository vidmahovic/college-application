<?php

namespace App\Transfomers;

use App\Models\Faculty;
use League\Fractal;

class FacultyTransformer extends Fractal\TransformerAbstract
{


	public function transform(Faculty $faculty)
	{
	    return [
	    	'id'		=> (int) $faculty->id,
	        'name'		=> (string) $faculty->name,
	        'acronym'		=> (string) $faculty->acronym,
	        'id_district'		=> (int) $program->id_district,
	        'id_university'		=> (int) $program->id_university
	}
}