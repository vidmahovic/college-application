<?php

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $excel = app('excel');

        $data = $excel->load('database/files/Drzava.xls', function($reader) {})->get();
        if(!empty($data) && $data->count()){
            foreach ($data as $d) {
                Country::create(array(
                    "id" => intval($d['id_drzava']),
                    "name" => (string)$d['ime_drzava'],
                	"eu" => (boolean)((string)$d['znotraj_eu'] == "D" ? true : false)));
            }
        }
    }
}
