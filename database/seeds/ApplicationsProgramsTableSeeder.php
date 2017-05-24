<?php

use App\Models\ApplicationsPrograms;
use Illuminate\Database\Seeder;

class ApplicationsProgramsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $programs = ["ZE10", "ZB00", "ZE30", "ZE40", "ZE50", "ZE60", "ZE70", "WY00"];
        for ($i = 2; $i <= 100; $i++) {
            ApplicationsPrograms::create(array(
                'id' => $i, // 100 vpisnih listov
                'application_id' => $i, // vsi oddali le eno prijavo
                'faculty_program_id' => $programs[intval(rand(0,count($programs)-1))],
                'status' => intval(rand(0,1)) == 1,
                'choice_number' => intval(rand(1,3))
            ));
        }
    }
}
