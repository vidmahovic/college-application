<?php

use Illuminate\Database\Seeder;

/**
 * Class ApplicationTableSeeder
 *
 * @package \\${NAMESPACE}
 */
class ApplicationTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();

        factory(App\Models\Application::class, 200)->create()->each(function($app) use($faker) {


            $mailing_address_id = \App\Models\City::pluck('id')->shuffle()->take(1)->toArray()[0];
            $permanent_address_id = \App\Models\City::pluck('id')->shuffle()->take(1)->toArray()[0];

            // Apply random choices.
            $wish_count = 0;
            $wish_ids = \App\Models\FacultyProgram::pluck('id')->shuffle()->take(rand(1,3))->mapWithKeys(function($wish_id) use(&$wish_count, $faker) {
                $wish_count += 1;
                return [$wish_id => ['choice_number' => $wish_count, 'status' => $faker->boolean(20)]];
            })->toArray();

            $app->cities()->sync([$mailing_address_id => ['address_type' => 1, 'address' => $faker->streetAddress]]);
            $app->permanentAddress()->sync([$permanent_address_id => ['address_type' => 0, 'address' => $faker->address]]);
            $app->wishes()->sync($wish_ids);
        });
    }
}
