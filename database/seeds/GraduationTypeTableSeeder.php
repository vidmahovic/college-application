<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use \App\GraduationType;

class GraduationTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $excel = App::make('excel');

        $data = collect($excel->load('database/files/Koncal_sr_sola.xlsx', function($reader) {})->get());

        if($data->isNotEmpty()) {
            $data->each(function($datum) {
                GraduationType::create([
                    'name' => $datum['ime_okrajsano']
                ]);
            });
        }
    }
}
