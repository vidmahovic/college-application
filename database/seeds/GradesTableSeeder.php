<?php

use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradesTableSeeder extends Seeder
{
    public function run()
    {
        $grade = Grade::create([
            'application_id' => 1,
            'subject_id' => 'M103', // slo splosna
            'grade' => 5
        ]);

        $grade = Grade::create([
            'application_id' => 1,
            'subject_id' => 'M401', // mat splosna
            'grade' => 4
        ]);

        $grade = Grade::create([
            'application_id' => 1,
            'subject_id' => 'M241', // ang splosna
            'grade' => 4
        ]);

        $grade = Grade::create([
            'application_id' => 1,
            'subject_id' => 'M431', // kem splosna
            'grade' => 3
        ]);

        $grade = Grade::create([
            'application_id' => 1,
            'subject_id' => 'M541', // psi splosna
            'grade' => 5
        ]);

        // ---

        $grade = Grade::create([
            'application_id' => 2,
            'subject_id' => 'L103', // slo poklicna, visja raven
            'grade' => 8
        ]);

        $grade = Grade::create([
            'application_id' => 2,
            'subject_id' => 'L401', // mat poklicna
            'grade' => 4
        ]);

        $grade = Grade::create([
            'application_id' => 2,
            'subject_id' => 'L241', // ang poklicna
            'grade' => 4
        ]);

        $grade = Grade::create([
            'application_id' => 2,
            'subject_id' => 'L411', // fiz poklicna
            'grade' => 2
        ]);

        $grade = Grade::create([
            'application_id' => 2,
            'subject_id' => 'M541', // psi splosna
            'grade' => 5
        ]);

    }
}