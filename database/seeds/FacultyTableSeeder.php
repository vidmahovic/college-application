<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use \App\Faculty;

class FacultyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $excel = App::make('excel');

        $data = $excel->load('database/files/VIS_zavod.xls', function($reader) {})->get();
        if(!empty($data) && $data->count()){
            foreach ($data as $d) {
                Faculty::create(array(
                    "id" => intval($d['id_vis_zavod']),
                    "name" => (string)$d['ime_vis_zavod'],
                    "acronym" => (string)$d['kratica'],
                    "id_university" => intval($d['id_univerza']),
                    "id_district" => intval($d['id_obcina'])));
            }
        }
    }
}
