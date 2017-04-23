<?php

use App\Models\GraduationType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class GraduationTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $excel = app('excel');

        $data = collect($excel->load('database/files/Koncal_sr_sola.xlsx', function($reader) {})->get());

        if($data->isNotEmpty()) {
            $data->each(function($datum) {
                GraduationType::create([
                    'id' => $datum['id_koncal_sr_sola'],
                    'name' => $datum['ime_okrajsano']
                ]);
            });
        }
    }
}
