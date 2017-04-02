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

    public function faculty(){
        return $this->belongsTo(Faculty::class);
    }

    public function scopeFacultyFilter($query, $id){
        return $query->where('faculty_id', $id);
    }

    /*
    public function scopeFilter($query, $filters){
        if($month = $filters['month']){
            $query->whereMonth('created_at', Carbon::parse($month)->month);
        }

        if($year = $filters['year']){
            $query->whereYear('created_at', Carbon::parse($year)->year);
        }

        // return $query->get();
    }

    public static function archives()
    {
        return selectRaw('year(created_at) year, monthname(created_at) month, count(*) published')
            ->groupBy('year', 'month')->orderByRaw('min(created_at) desc')->get()->toArray();
    }
    */

}