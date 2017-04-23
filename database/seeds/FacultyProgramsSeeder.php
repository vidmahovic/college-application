<?php

use App\Models\FacultyProgram;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

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
            foreach ($data as $d) {

                $doubleDegree = 0; // enopredmetni
                $is_regular = 1; // redni

                if (strpos($d['ime_program'], 'DVOPREDMETNI') == true) {
                    $doubleDegree = 1; // dvopredmetni
                }
                if ($d['id_nacin_studija'] == 2) {
                    $is_regular = 0; // izredni
                }
                if (substr($d['ime_program'], -2) == "VS") {
                    $type = 1; // vs
                }
                else if (substr($d['ime_program'], -2) == "UN") {
                    $type = 0; // uni
                }
                else {
                    $type = 2; // mag
                }
                if(FacultyProgram::find((string)$d['id_program_prg']) == null)
                    FacultyProgram::create(array(
                        "id" => (string)$d['id_program_prg'],
                        "name" => (string)$d['ime_program'],
                        "faculty_id" => intval($d['id_vis_zavod_prg']),
                        'min_points' => 0,
                        'type' => intval($type),
                        'allow_double_degree' => intval($doubleDegree),
                        'is_regular' => intval($is_regular)));
            }
        }
    }
}
