<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use \App\University;

class UniversityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $excel = App::make('excel');

        $data = $excel->load('database/files/Univerza.xlsx', function($reader) {})->get();
        if(!empty($data) && $data->count()){
            foreach ($data as $d) {
                University::create(array(
                    "id" => intval($d['id_univerza']),
                    "name" => (string)$d['ime_univerza']));
            }
        }
    }
}
