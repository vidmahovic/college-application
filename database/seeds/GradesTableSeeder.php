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
            'matura_mark' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 1,
            'subject_id' => 'M401', // mat splosna
            'matura_mark' => 4
        ]);
        $grade = Grade::create([
            'application_id' => 1,
            'subject_id' => 'M241', // ang splosna
            'matura_mark' => 4
        ]);
        $grade = Grade::create([
            'application_id' => 1,
            'subject_id' => 'M431', // kem splosna
            'matura_mark' => 3
        ]);
        $grade = Grade::create([
            'application_id' => 1,
            'subject_id' => 'M541', // psi splosna
            'matura_mark' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 1,
            'subject_id' => 'U003', // uspeh 3. letnik
            'matura_mark' => 4
        ]);
        $grade = Grade::create([
            'application_id' => 1,
            'subject_id' => 'U004', // uspeh 4. letnik
            'matura_mark' => 4
        ]);

        // Miha Mihič
        $grade = Grade::create([
            'application_id' => 2,
            'subject_id' => 'L103', // slo poklicna, visja raven
            'matura_mark' => 3
        ]);
        $grade = Grade::create([
            'application_id' => 2,
            'subject_id' => 'L401', // mat poklicna
            'matura_mark' => 4
        ]);
        $grade = Grade::create([
            'application_id' => 2,
            'subject_id' => 'L241', // ang poklicna
            'matura_mark' => 4
        ]);
        $grade = Grade::create([
            'application_id' => 2,
            'subject_id' => 'L411', // fiz poklicna
            'matura_mark' => 2
        ]);
        $grade = Grade::create([
            'application_id' => 2,
            'subject_id' => 'M541', // psi splosna
            'matura_mark' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 2,
            'subject_id' => 'U003', // uspeh 3. letnik
            'matura_mark' => 4
        ]);
        $grade = Grade::create([
            'application_id' => 2,
            'subject_id' => 'U004', // uspeh 4. letnik
            'matura_mark' => 3
        ]);

        // Božidar Daribožič
        $grade = Grade::create([
            'application_id' => 3,
            'subject_id' => 'M103',
            'matura_mark' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 3,
            'subject_id' => 'M401',
            'matura_mark' => 4
        ]);
        $grade = Grade::create([
            'application_id' => 3,
            'subject_id' => 'M431',
            'matura_mark' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 3,
            'subject_id' => 'M241',
            'matura_mark' => 2
        ]);
        $grade = Grade::create([
            'application_id' => 3,
            'subject_id' => 'M541',
            'matura_mark' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 3,
            'subject_id' => 'U003', // uspeh 3. letnik
            'matura_mark' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 3,
            'subject_id' => 'U004', // uspeh 4. letnik
            'matura_mark' => 2
        ]);

        // Karolina Travnikar
        $grade = Grade::create([
            'application_id' => 4,
            'subject_id' => 'L103', // slo poklicna, visja raven
            'matura_mark' => 3
        ]);
        $grade = Grade::create([
            'application_id' => 4,
            'subject_id' => 'L401', // mat poklicna
            'matura_mark' => 4
        ]);
        $grade = Grade::create([
            'application_id' => 4,
            'subject_id' => 'L241', // ang poklicna
            'matura_mark' => 4
        ]);
        $grade = Grade::create([
            'application_id' => 4,
            'subject_id' => 'L411', // fiz poklicna
            'matura_mark' => 2
        ]);
        $grade = Grade::create([
            'application_id' => 4,
            'subject_id' => 'M541', // psi splosna
            'matura_mark' => 1
        ]);
        $grade = Grade::create([
            'application_id' => 4,
            'subject_id' => 'U003', // uspeh 3. letnik
            'matura_mark' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 4,
            'subject_id' => 'U004', // uspeh 4. letnik
            'matura_mark' => 2
        ]);

        // Janez Novak
        $grade = Grade::create([
            'application_id' => 5,
            'subject_id' => 'M103',
            'matura_mark' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 5,
            'subject_id' => 'M401',
            'matura_mark' => 4
        ]);
        $grade = Grade::create([
            'application_id' => 5,
            'subject_id' => 'M431',
            'matura_mark' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 5,
            'subject_id' => 'M241',
            'matura_mark' => 4
        ]);
        $grade = Grade::create([
            'application_id' => 5,
            'subject_id' => 'M541',
            'matura_mark' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 5,
            'subject_id' => 'X401',
            'matura_mark' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 5,
            'subject_id' => 'U003', // uspeh 3. letnik
            'matura_mark' => 2
        ]);
        $grade = Grade::create([
            'application_id' => 5,
            'subject_id' => 'U004', // uspeh 4. letnik
            'matura_mark' => 2
        ]);

        // Metka Jankec
        $grade = Grade::create([
            'application_id' => 6,
            'subject_id' => 'L103',
            'matura_mark' => 3
        ]);
        $grade = Grade::create([
            'application_id' => 6,
            'subject_id' => 'L401',
            'matura_mark' => 4
        ]);
        $grade = Grade::create([
            'application_id' => 6,
            'subject_id' => 'L241',
            'matura_mark' => 4
        ]);
        $grade = Grade::create([
            'application_id' => 6,
            'subject_id' => 'L411',
            'matura_mark' => 2
        ]);
        $grade = Grade::create([
            'application_id' => 6,
            'subject_id' => 'M541',
            'matura_mark' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 6,
            'subject_id' => 'U003', // uspeh 3. letnik
            'matura_mark' => 5
        ]);
        $grade = Grade::create([
            'application_id' => 6,
            'subject_id' => 'U004', // uspeh 4. letnik
            'matura_mark' => 5
        ]);

        // Mirko Ojojoj
        // ni podatkov
    }
}
