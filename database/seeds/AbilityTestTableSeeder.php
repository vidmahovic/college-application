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
            'faculty_program_id' => "SU00",
            'max_points' => 120,
            'min_points' => 30,
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now()
        ]);

        ApplicationAbilityTest::create([ // user -> Rok Zidarn
            'application_id' => 1,
            'ability_test_id' => $ability_test->id,
            'points' => 80,
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now()
        ]);

        ApplicationAbilityTest::create([ // user -> Miha Mihič
            'application_id' => 2,
            'ability_test_id' => $ability_test->id,
            'points' => 20,
            'updated_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now()
        ]);
    }

}
