<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use \App\Profession;

class ProfessionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $excel = App::make('excel');

        $data = $excel->load('database/files/Poklic.xlsx', function($reader) {})->get();
        if(!empty($data) && $data->count()){
            foreach ($data as $d) {
                Profession::create(array(
                    "id" => intval($d['id_poklic']),
                    "name" => (string)$d['ime_poklic']));
            }
        }
    }
}
