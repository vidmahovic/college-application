<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use \App\Citizen;

class CitizensTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $excel = App::make('excel');

        $data = $excel->load('database/files/Drzavljan.xlsx', function($reader) {})->get();
        if(!empty($data) && $data->count()){
            foreach ($data as $d) {
                Citizen::create(array(
                    "id" => intval($d['id_drzavljan']),
                    "name" => (string)$d['text_za_izpis']));
            }
        }
    }
}
