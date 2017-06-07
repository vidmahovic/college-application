<?php

use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradesTableSeeder extends Seeder
{
    public function run()
    {

        // Rok Zidarn
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
        $grade = Grade::create([
            'application_id' => 1,
            'subject_id' => 'U003', // uspeh 3. letnik
            'grade' => 4
        ]);
        $grade = Grade::create([
            'application_id' => 1,
            'subject_id' => 'U004', // uspeh 4. letnik
            'grade' => 4
        ]);

        // Miha Mihič
        $grade = Grade::create([
            'application_id' => 2,
            'subject_id' => 'L103', // slo poklicna, visja raven
            'grade' => 3
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
        $grade = Grade::create([
            'application_id' => 2,
            'subject_id' => 'U003', // uspeh 3. letnik
            'grade' => 4
        ]);
        $grade = Grade::create([
            'application_id' => 2,
            'subject_id' => 'U004', // uspeh 4. letnik
            'grade' => 3
        ]);

        // Božidar Daribožič
        $grade = Grade::create([
            'application_id' => 3,
            'subject_id' => 'M103',
            'grade' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 3,
            'subject_id' => 'M401',
            'grade' => 4
        ]);
        $grade = Grade::create([
            'application_id' => 3,
            'subject_id' => 'M431',
            'grade' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 3,
            'subject_id' => 'M241',
            'grade' => 2
        ]);
        $grade = Grade::create([
            'application_id' => 3,
            'subject_id' => 'M541',
            'grade' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 3,
            'subject_id' => 'U003', // uspeh 3. letnik
            'grade' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 3,
            'subject_id' => 'U004', // uspeh 4. letnik
            'grade' => 2
        ]);

        // Karolina Travnikar
        $grade = Grade::create([
            'application_id' => 4,
            'subject_id' => 'L103', // slo poklicna, visja raven
            'grade' => 3
        ]);
        $grade = Grade::create([
            'application_id' => 4,
            'subject_id' => 'L401', // mat poklicna
            'grade' => 4
        ]);
        $grade = Grade::create([
            'application_id' => 4,
            'subject_id' => 'L241', // ang poklicna
            'grade' => 4
        ]);
        $grade = Grade::create([
            'application_id' => 4,
            'subject_id' => 'L411', // fiz poklicna
            'grade' => 2
        ]);
        $grade = Grade::create([
            'application_id' => 4,
            'subject_id' => 'M541', // psi splosna
            'grade' => 1
        ]);
        $grade = Grade::create([
            'application_id' => 4,
            'subject_id' => 'U003', // uspeh 3. letnik
            'grade' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 4,
            'subject_id' => 'U004', // uspeh 4. letnik
            'grade' => 2
        ]);

        // Janez Novak
        $grade = Grade::create([
            'application_id' => 5,
            'subject_id' => 'M103',
            'grade' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 5,
            'subject_id' => 'M401',
            'grade' => 4
        ]);
        $grade = Grade::create([
            'application_id' => 5,
            'subject_id' => 'M431',
            'grade' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 5,
            'subject_id' => 'M241',
            'grade' => 4
        ]);
        $grade = Grade::create([
            'application_id' => 5,
            'subject_id' => 'M541',
            'grade' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 5,
            'subject_id' => 'X401',
            'grade' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 5,
            'subject_id' => 'U003', // uspeh 3. letnik
            'grade' => 2
        ]);
        $grade = Grade::create([
            'application_id' => 5,
            'subject_id' => 'U004', // uspeh 4. letnik
            'grade' => 2
        ]);

        // Metka Jankec
        $grade = Grade::create([
            'application_id' => 6,
            'subject_id' => 'L103',
            'grade' => 3
        ]);
        $grade = Grade::create([
            'application_id' => 6,
            'subject_id' => 'L401',
            'grade' => 4
        ]);
        $grade = Grade::create([
            'application_id' => 6,
            'subject_id' => 'L241',
            'grade' => 4
        ]);
        $grade = Grade::create([
            'application_id' => 6,
            'subject_id' => 'L411',
            'grade' => 2
        ]);
        $grade = Grade::create([
            'application_id' => 6,
            'subject_id' => 'M541',
            'grade' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 6,
            'subject_id' => 'U003', // uspeh 3. letnik
            'grade' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 6,
            'subject_id' => 'U004', // uspeh 4. letnik
            'grade' => 5
        ]);

        // Mirko Ojojoj
        // ni podatkov
    }
}