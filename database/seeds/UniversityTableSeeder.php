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

        $data = collect($excel->load('database/files/Univerza.xlsx', function($reader) {})->get());
        if($data->isNotEmpty()) {
            $data->each(function($datum) {
                University::create([
                    "name" => $datum['ime_univerza']
                ]);
            });
        }
    }
}
