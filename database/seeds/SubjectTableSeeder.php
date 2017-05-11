<?php

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $excel = app('excel');

        $data = collect($excel->load('database/files/ElementNov.xls', function($reader) {})->get());
        if($data->isNotEmpty()) {
            $data->each(function($datum) {
                Subject::create([
                    "id" => $datum['id_element'],
                    "name" => $datum['ime_element']
                ]);
            });
        }
    }
}
