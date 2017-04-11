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

        $data = collect($excel->load('database/files/Obcina.xls', function($reader) {})->get());
        if($data->isNotEmpty()) {
            $data->each(function($datum) {
                District::create([
                    "name" => (string)$datum['ime_obcina']
                ]);
            });
        }
    }
}
