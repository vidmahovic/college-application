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

    /*
    public function scopeIncomplete($query){ // scope prefix!
        // with scope you can chain methods, such as where()
        return $query->where('completed', 0);
    }

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

    /*
    $newContacts = DB::table('contact')->where('created_at', '>', Carbon::now()->subDay())->get();
    $mediumDrinks = DB::table('drinks')->whereBetween('size', [6, 12])->distinct()->get();
    $contacts = DB::table('contacts') >orderBy('last_name', 'asc')->get();
    $page4 = DB::table('contacts')->skip(30)->take(10)->get();

    public function scopeActiveVips($query)
    {
        return $query->where('vip', true)->where('trial', false);
    }
    $activeVips = Contact::activeVips()->get();
    */

}