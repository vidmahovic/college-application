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
            foreach ($data as $key => $value) {
                $insert = ['id' => $value->ID_UNIVERZA, 'name' => $value->IME_UNIVERZA];
                University::create(array(
                    "id" => intval($insert['id']),
                    "name" => (string)$insert['name']));
            }
        }
    }
}
