<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacultyProgram extends Model // PROGRAM
{
    protected $table = 'faculty_programs';

    protected $fillable = ['id', 'name', 'faculty_id', 'allow_double_degree', 'is_regular', 'type', 'min_points'];
    //protected $guarded = ['id'];

    // TODO: število razpisanih

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

    public function applicationPrograms(){
        return $this->hasMany(ApplicationsPrograms::class);
    }

    public function countAll(){
       return $this->hasMany(ApplicationsPrograms::class)->selectRaw('faculty_program_id, count(*) as count');
    }

    public function countAccepted(){
       return $this->hasMany(ApplicationsPrograms::class)->selectRaw('faculty_program_id, count(*) as count')->where('status', '=', 1);
    }

    public function scopeArrangeBy($query, $filters){
        if(intval($filters['fid']) > 0){
            $query->where('faculty_id', intval($filters['fid']));
        }
        if(intval($filters['type']) >= 0 && intval($filters['type']) <= 2 && $filters['type'] != null){
            $query->where('type', $filters['type']);
        }
        else if((intval($filters['is_regular']) == 0 || intval($filters['is_regular']) == 1) && $filters['is_regular'] != null){
            $query->where('is_regular', intval($filters['is_regular']));
        }
        return $query->orderBy('id', 'asc')->orderBy('type', 'asc')->orderBy('is_regular', 'asc');
    }
}
