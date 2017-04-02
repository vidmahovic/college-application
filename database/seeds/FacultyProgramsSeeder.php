<?php

use Illuminate\Database\Seeder;
use \App\FacultyProgram;

class FacultyProgramsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // FRI
        FacultyProgram::create(array(
            'id' => 1,
            'name' => "Bolonjski univerzitetni študij Računalništvo in informatika",
            'faculty_id'  => 1,
            'allow_double_degree'  => 0,
            'is_regular'  => true,
            'min_points' => 81
        ));

        FacultyProgram::create(array(
            'id' => 2,
            'name' => "Bolonjski visokošolski študij Računalništvo in informatika",
            'faculty_id'  => 1,
            'allow_double_degree'  => 0,
            'is_regular'  => true,
            'min_points' => 63
        ));

        FacultyProgram::create(array(
            'id' => 3,
            'name' => "Bolonjski izredni študij Računalništvo in matematika",
            'faculty_id'  => 1,
            'allow_double_degree'  => 1,
            'is_regular'  => false,
            'min_points' => 77
        ));

        //FU
        FacultyProgram::create(array(
            'id' => 4,
            'name' => "Bolonjski univerzitetni študij Upravljanje javnega sektorja",
            'faculty_id'  => 2,
            'allow_double_degree'  => 0,
            'is_regular'  => true,
            'min_points' => 67
        ));

        //FMF
        FacultyProgram::create(array(
            'id' => 5,
            'name' => "Bolonjski univerzitetni študij Matematika",
            'faculty_id'  => 3,
            'allow_double_degree'  => 0,
            'is_regular'  => true,
            'min_points' => 54
        ));

        FacultyProgram::create(array(
            'id' => 6,
            'name' => "Bolonjski visokošolski študij Praktična matemaika",
            'faculty_id'  => 3,
            'allow_double_degree'  => 0,
            'is_regular'  => true,
            'min_points' => 51
        ));

        // BF
        FacultyProgram::create(array(
            'id' => 7,
            'name' => "Bolonjski univerzitetni študij Gozdarstvo in obnovljivi gozdni viri",
            'faculty_id'  => 4,
            'allow_double_degree'  => 0,
            'is_regular'  => true,
            'min_points' => 64
        ));

        // FA
        FacultyProgram::create(array(
            'id' => 8,
            'name' => "Bolonjski univerzitetni študij Slovenistika",
            'faculty_id'  => 5,
            'allow_double_degree'  => 1,
            'is_regular'  => true,
            'min_points' => 89
        ));

        // FF
        FacultyProgram::create(array(
            'id' => 9,
            'name' => "Bolonjski univerzitetni študij Anglistika",
            'faculty_id'  => 6,
            'allow_double_degree'  => 1,
            'is_regular'  => true,
            'min_points' => 99
        ));

        FacultyProgram::create(array(
            'id' => 10,
            'name' => "Bolonjski univerzitetni študij Nemcistika",
            'faculty_id'  => 6,
            'allow_double_degree'  => 1,
            'is_regular'  => true,
            'min_points' => 13
        ));

        FacultyProgram::create(array(
            'id' => 11,
            'name' => "Enoviti magistrski študij Arhitektura",
            'faculty_id'  => 6,
            'allow_double_degree'  => 1,
            'is_regular'  => true,
            'min_points' => 72
        ));
    }
}
