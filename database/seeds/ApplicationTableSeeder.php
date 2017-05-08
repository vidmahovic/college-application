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
        factory(App\Models\Application::class, 50)->create()->each(function($app) {


            $mailing_address_id = \App\Models\City::pluck('id')->shuffle()->take(1)->toArray();
            $permanent_address_id = \App\Models\City::pluck('id')->shuffle()->take(1)->toArray();
            $wishes_ids = \App\Models\FacultyProgram::pluck('id')->shuffle()->take(rand(1,3))->toArray();

            $app->mailingAddress()->sync($mailing_address_id);
            $app->permanentAddress()->sync($permanent_address_id);
            $app->wishes()->sync($wishes_ids); // od 1 do 3 želij.
        });
    }
}
