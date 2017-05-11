<?php

use App\Models\University;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

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
                    "id" => $datum['id_univerza'],
                    "name" => $datum['ime_univerza']
                ]);
            });
        }
    }
}
