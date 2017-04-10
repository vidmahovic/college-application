<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use \App\District;

class DistrictsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $excel = App::make('excel');

        $data = $excel->load('database/files/Obcina.xls', function($reader) {})->get();
        if(!empty($data) && $data->count()){
            foreach ($data as $d) {
                District::create(array(
                    "id" => intval($d['id_obcina']),
                    "name" => (string)$d['ime_obcina']));
            }
        }
    }
}
