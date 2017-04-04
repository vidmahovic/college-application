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
            foreach ($data as $key => $value) {
                $insert = ['id' => $value->ID_VIS_ZAVOD, 'name' => $value->IME_VIS_ZAVOD,
                    'acronym' => $value->KRATICA, 'id_district' => $value->ID_OBCINA, 'id_university' => $value->ID_UNIVERZA];
                Faculty::create(array(
                    "id" => intval($insert['id']),
                    "name" => (string)$insert['name'],
                    "acronym" => (string)$insert['name'],
                    "id_university" => intval($insert['id_university']),
                    "id_district" => intval($insert['id_district'])));
            }
        }
    }
}
