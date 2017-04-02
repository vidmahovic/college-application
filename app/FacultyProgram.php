<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacultyProgram extends Model
{
    protected $table = 'faculty_programs';

    protected $fillable = ['name', 'faculty_id', 'allow_double_degree', 'is_regular', 'min_points'];
    protected $guarded = ['id'];
    protected $with = ['faculty'];

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

    public function scopeFilter($query, $filters){
        if(intval($filters['fid']) > 0){
            $query->where('faculty_id', $filters['fid']);
        }
        if(intval($filters['min_points']) > 0){
            $query->where('min_points', '>', $filters['min_points']);
        }
        if($filters['is_regular'] == "true" || $filters['is_regular'] == "false"){
            $is_regular = $filters['is_regular'] == "true" ? 1 : 0;
            $query->where('is_regular', $is_regular);
        }

        return $query->orderBy('id', 'desc')->get();
    }

    /*
    public function scopeFilter($query, $filters){

    public static function archives()
    {
        return selectRaw('year(created_at) year, monthname(created_at) month, count(*) published')
            ->groupBy('year', 'month')->orderByRaw('min(created_at) desc')->get()->toArray();
    }
    */

}