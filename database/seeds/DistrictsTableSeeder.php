<?php

use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

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
                    "id" => $datum["id_obcina"],
                    "name" => (string)$datum['ime_obcina']
                ]);
            });
        }
    }
}
