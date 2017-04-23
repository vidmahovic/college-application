<?php

use App\Models\Profession;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class ProfessionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $excel = app('excel');

        $data = collect($excel->load('database/files/Poklic.xlsx', function($reader) {})->get());
        if($data->isNotEmpty()) {
            $data->each(function($datum) {
                Profession::create([
                    "id" => $datum['id_poklic'],
                    "name" => $datum['ime_poklic']
                ]);
            });
        }
    }
}
