<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class FacultyProgram extends Model
{
    protected $table = 'faculty_programs';

    protected $fillable = ['name', 'faculty_id', 'allow_double_degree', 'is_regular', 'min_points'];
    protected $guarded = ['id'];

    protected $casts = [
        'name' => 'string',
        'faculty_id' => 'integer',
        'allow_double_degree' => 'integer',
        'is_regular' => 'boolean',
        'min_points' => 'integer'
    ];

}