<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacultyProgram extends Model // PROGRAM
{
    protected $table = 'faculty_programs';

    protected $fillable = ['id', 'name', 'faculty_id', 'allow_double_degree', 'is_regular', 'type', 'min_points'];
    //protected $guarded = ['id'];

    protected $casts = [
        'id' => 'string',
        'name' => 'string',
        'type' => 'integer', // 0,1,2 - uni,bvs,mag
        'faculty_id' => 'integer',
        'allow_double_degree' => 'boolean', //0,1 - enopredmetni, dvopredmetni
        'is_regular' => 'boolean', // 0,1 - izredni, redni
        'min_points' => 'integer'
    ];

    public function faculty(){
        return $this->belongsTo(Faculty::class);
    }

    public function scopeFilter($query, $filters){
        if(intval($filters['fid']) > 0){
            $query->where('faculty_id', $filters['fid']);
        }
        if(intval($filters['type']) >= 0 || intval($filters['type']) <= 2){
            $query->where('type', $filters['type']);
        }
        if($filters['is_regular'] == "true" || $filters['is_regular'] == "false"){
            $is_regular = $filters['is_regular'] == "true" ? 1 : 0;
            $query->where('is_regular', $is_regular);
        }

        return $query->orderBy('id', 'asc')->orderBy('type', 'asc')->orderBy('is_regular', 'asc')->get();
    }
}