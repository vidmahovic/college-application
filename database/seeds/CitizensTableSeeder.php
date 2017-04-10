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

        $data = collect($excel->load('database/files/Drzavljan.xlsx', function($reader) {})->get());
        if($data->isNotEmpty()){
            $data->each(function($datum) {
                Citizen::create([
                    "name" => $datum['text_za_izpis']
                ]);
            });
        }
    }
}
