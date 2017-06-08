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
            'name' => 1,
            'type' => 0,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 40
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 0,
            'type' => 0,    // splosna in poklicna matura
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 60
        ]);

        $faculty_program_id = 'ZE20';
        EnrollmentCondition::create([ // splosna matura
            'faculty_program_id' => $faculty_program_id,
            'name' => 1,
            'type' => 1,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 20
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 2,
            'type' => 1,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 20
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 0,
            'type' => 1,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 60
        ]);

        EnrollmentCondition::create([ // poklicna matura
            'faculty_program_id' => $faculty_program_id,
            'name' => 1,
            'type' => 2,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 20
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 2,
            'type' => 2,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 30
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 0,
            'type' => 2,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 50
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 5,
            'type' => 2,
            'conditions_subject_id' => null,
            'conditions_profession_id' => 57311,
            'weight' => null
        ]);

        $faculty_program_id = 'ZE30';
        EnrollmentCondition::create([ // splosna matura
            'faculty_program_id' => $faculty_program_id,
            'name' => 0,
            'type' => 0,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 20
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 1,
            'type' => 0,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 20
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 4,
            'type' => 0,
            'conditions_subject_id' => 'S251',
            'conditions_profession_id' => null,
            'weight' => 60
        ]);

        // - prosojnice: FRI, FMF, FU, BF, FA, FF

        // FRI

        $faculty_program_id = 'VT00'; // FRI UNI, splošna matura
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 1,
            'type' => 1,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 40
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 0,
            'type' => 1,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 60
        ]);

        EnrollmentCondition::create([ // FRU UNI, poklicna matura
            'faculty_program_id' => $faculty_program_id,
            'name' => 1,
            'type' => 2,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 40
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 2,
            'type' => 2,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 20
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 0,
            'type' => 2,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 40
        ]);

        $faculty_program_id = 'VU00'; // FRI VS
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 1,
            'type' => 0,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 40
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 0,
            'type' => 0,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 60
        ]);

        $faculty_program_id = 'VV00'; // FRI + FMF
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 1,
            'type' => 0,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 40
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 0,
            'type' => 0,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 60
        ]);

        // FMF

        $faculty_program_id = 'SZ00'; // FMF Matematika UN splosna matura
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 1,
            'type' => 1,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 20
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 0,
            'type' => 1,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 30
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 3,
            'type' => 1,
            'conditions_subject_id' => 'M401',
            'conditions_profession_id' => null,
            'weight' => 30
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 3,
            'type' => 1,
            'conditions_subject_id' => 'X401',
            'conditions_profession_id' => null,
            'weight' => 20
        ]);

        EnrollmentCondition::create([ // FMF Matematika UN poklicna matura
            'faculty_program_id' => $faculty_program_id,
            'name' => 0,
            'type' => 2,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 20
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 1,
            'type' => 2,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 10
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 3,
            'type' => 2,
            'conditions_subject_id' => 'M401',
            'conditions_profession_id' => null,
            'weight' => 40
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 3,
            'type' => 2,
            'conditions_subject_id' => 'X401',
            'conditions_profession_id' => null,
            'weight' => 30
        ]);

        $faculty_program_id = 'TH00'; // FMF Praktična Matematika
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 1,
            'type' => 0,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 20
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 0,
            'type' => 0,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 30
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 3,
            'type' => 0,
            'conditions_subject_id' => 'M401',
            'conditions_profession_id' => null,
            'weight' => 30
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 3,
            'type' => 0,
            'conditions_subject_id' => 'X401',
            'conditions_profession_id' => null,
            'weight' => 30
        ]);

        // FU

        $faculty_program_id = 'R400'; // FU, splošna matura
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 1,
            'type' => 1,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 40
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 0,
            'type' => 1,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 60
        ]);

        EnrollmentCondition::create([ // FU poklicna matura
            'faculty_program_id' => $faculty_program_id,
            'name' => 1,
            'type' => 2,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 40
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 2,
            'type' => 2,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 20
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 0,
            'type' => 2,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 40
        ]);

        // BF

        $faculty_program_id = 'SD00'; // BF Gozdarstvo UN, splošna matura
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 1,
            'type' => 1,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 40
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 0,
            'type' => 1,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 60
        ]);

        EnrollmentCondition::create([  // BF Gozdarstvo UN, poklicna matura
            'faculty_program_id' => $faculty_program_id,
            'name' => 1,
            'type' => 2,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 40
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 2,
            'type' => 2,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 20
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 0,
            'type' => 2,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 40
        ]);

        // FA

        $faculty_program_id = 'SU00'; // FA Arhitektura MAG
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 1,
            'type' => 0,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 10
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 0,
            'type' => 0,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 10
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 4,
            'type' => 0,
            'conditions_subject_id' => 'S251',
            'conditions_profession_id' => null,
            'weight' => 80
        ]);

        // CALCULATION TEST

        $faculty_program_id = 'SG00'; // BF Lesarstvo UN
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 1,
            'type' => 0,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 40
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 0,
            'type' => 0,
            'conditions_subject_id' => null,
            'conditions_profession_id' => null,
            'weight' => 60
        ]);
        EnrollmentCondition::create([
            'faculty_program_id' => $faculty_program_id,
            'name' => 5,
            'type' => 0,
            'conditions_subject_id' => null,
            'conditions_profession_id' => 51001,
            'weight' => 0
        ]);

    }
}
