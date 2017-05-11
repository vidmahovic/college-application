<?php

use App\Models\Citizen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class CitizensTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $excel = app('excel');

        $data = collect($excel->load('database/files/Drzavljan.xlsx', function($reader) {})->get());
        if($data->isNotEmpty()){
            $data->each(function($datum) {
                Citizen::create([
                    "id" => $datum["id_drzavljan"],
                    "name" => $datum['text_za_izpis']
                ]);
            });
        }
    }
}
