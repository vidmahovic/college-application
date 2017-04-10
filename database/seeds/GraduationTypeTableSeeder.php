<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use \App\GraduationType;

class GraduationTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $excel = App::make('excel');

        $data = $excel->load('database/files/Koncal_sr_sola.xlsx', function($reader) {})->get();
        if(!empty($data) && $data->count()){
            foreach ($data as $d) {
                GraduationType::create(array(
                    "id" => intval($d['id_koncal_sr_sola']),
                    "name" => (string)$d['ime_okrajsano']));
            }
        }
    }
}
