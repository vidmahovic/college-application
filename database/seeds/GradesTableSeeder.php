<?php

use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradesTableSeeder extends Seeder
{
    public function run()
    {
        $grade = Grade::create([
            'application_id' => 1,
            'subject_id' => 'M411',
            'grade' => 5
        ]);
    }
}