<?php

use App\Models\EnrollmentCondition;
use Illuminate\Database\Seeder;

class EnrollmentConditionSeeder extends Seeder
{
    public function run()
    {
        // test

        $faculty_program_id = 'ZE10'; // splosna in poklicna matura
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 'Uspeh v 3. in 4. letniku',
            'type' => 0,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 40
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 'Uspeh na maturi',
            'type' => 0,    // splosna in poklicna matura
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 60
        ]);


        $faculty_program_id = 'ZE20';
        EnrollmentCondition::create([ // splosna matura
            'faculty_program_id' => $faculty_program_id,
            'name' => 'Uspeh v 3. in 4. letniku',
            'type' => 1,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 20
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 'Uspeh pri predpisanem predmetu',
            'type' => 1,
            'conditions_subject_id' => 'M411',
            'conditions_profession_id' => null,
            'weight' => 20
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 'Uspeh na maturi',
            'type' => 1,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 60
        ]);

        EnrollmentCondition::create([ // poklicna matura
            'faculty_program_id' => $faculty_program_id,
            'name' => 'Uspeh v 3. in 4. letniku',
            'type' => 2,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 20
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 'Uspeh pri dodatnem predmetu',
            'type' => 2,
            'conditions_subject_id' => 'M411',
            'conditions_profession_id' => null,
            'weight' => 30
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 'Uspeh na maturi',
            'type' => 2,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 50
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 'Poklic',
            'type' => 2,
            'conditions_subject_id' => null,
            'conditions_profession_id' => 57311,
            'weight' => null
        ]);
    }
}
