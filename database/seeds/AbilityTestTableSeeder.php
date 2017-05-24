<?php

use Illuminate\Database\Seeder;
use App\Models\AbilityTest;
use App\Models\ApplicationAbilityTest;

class AbilityTestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ability_test = AbilityTest::create([
            'faculty_program_id' => "ZE10",
            'max_points' => 120,
            'min_points' => 30,
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now()
        ]);

        ApplicationAbilityTest::create([ // user -> rok.zidarn@gmail.com, application -> 1
            'application_id' => 1,
            'ability_test_id' => $ability_test->id,
            'points' => 80,
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now()
        ]);
    }

}
