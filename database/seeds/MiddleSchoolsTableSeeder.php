<?php

use App\Models\MiddleSchool;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class MiddleSchoolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $excel = app('excel');

        $data = $excel->load('database/files/Sr_sola.xls', function($reader) {})->get();
        if(!empty($data) && $data->count()){
            foreach ($data as $d) {
                MiddleSchool::create(array(
                    "id" => intval($d['id_sr_sola']),
                    "name" => (string)$d['ime_sr_sola']));
            }
        }
    }
}
