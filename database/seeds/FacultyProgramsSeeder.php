<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
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
        $excel = App::make('excel');

        $data = $excel->load('database/files/Program.xls', function($reader) {})->get();
        if(!empty($data) && $data->count()){
            foreach ($data as $key => $value) {
                $doubleDegree = 0; // enopredmetni
                $is_regular = 1; // redni

                if (strpos($value->IME_PROGRAM, 'DVOPREDMETNI') == true) {
                    $doubleDegree = 1; // dvopredmetni
                }
                if (strpos($value->ID_NACIN, '2') == true) {
                    $is_regular = 0; // izredni
                }
                if (substr($value->IME_PROGRAM, -2) == "VS") {
                    $type = 1; // vs
                }
                else if (substr($value->IME_PROGRAM, -2) == "UN") {
                    $type = 0; // uni
                }
                else {
                    $type = 2; // mag
                }

                $insert = ['id' => $value->ID_PROGRAM_PRG, 'name' => $value->IME_PROGRAM,
                    'faculty_id' => $value->ID_VIS_ZAVOD_PRG, 'is_regular' => $is_regular,
                    'allow_double_degree' => $doubleDegree, 'type' => $type];

                FacultyProgram::create(array(
                    "id" => (string)$insert['id'],
                    "name" => (string)$insert['name'],
                    "faculty_id" => intval($insert['faculty_id']),
                    'min_points' => 0,
                    'type' => intval($insert['type']),
                    'allow_double_degree' => intval($insert['faculty_id']),
                    'is_regular' => intval($insert['faculty_id'])));
            }
        }
    }
}
