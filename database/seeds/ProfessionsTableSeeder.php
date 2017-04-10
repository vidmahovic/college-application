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

        $data = collect($excel->load('database/files/Poklic.xlsx', function($reader) {})->get());
        if($data->isNotEmpty()) {
            $data->each(function($datum) {
                Profession::create([
                    "name" => $datum['ime_poklic']
                ]);
            });
        }
    }
}
