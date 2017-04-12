<?php

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $excel = App::make('excel');

        $data = $excel->load('database/files/Posta.xlsx', function($reader) {})->get();
        if(!empty($data) && $data->count()){
            foreach ($data as $d) {
                City::create(array(
                    "id" => intval($d['id_posta']),
                    "name" => (string)$d['ime_posta']));
            }
        }
    }
}
