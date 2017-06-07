<?php

use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\ApplicationsPrograms;
use App\Models\ApplicationCity;

class ApplicationTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();

        // factory(App\Models\Application::class, 200)->create()->each(function($app) use($faker) {


        //     $mailing_address_id = \App\Models\City::pluck('id')->shuffle()->take(1)->toArray()[0];
        //     $permanent_address_id = \App\Models\City::pluck('id')->shuffle()->take(1)->toArray()[0];
        //     $mailing_country_id = \App\Models\Country::pluck('id')->shuffle()->take(1)->toArray()[0];
        //     $permanent_country_id = \App\Models\Country::pluck('id')->shuffle()->take(1)->toArray()[0];
        //     $country_id = \App\Models\Country::pluck('id')->shuffle()->take(1)->toArray()[0];

        //     // Apply random choices.
        //     $wish_count = 0;
        //     $wish_ids = \App\Models\FacultyProgram::pluck('id')->shuffle()->take(rand(1,3))->mapWithKeys(function($wish_id) use(&$wish_count, $faker) {
        //         $wish_count += 1;
        //         return [$wish_id => ['choice_number' => $wish_count, 'status' => $faker->boolean(20)]];
        //     })->toArray();

        //     $app->cities()->sync([
        //         $mailing_address_id => [
        //             'address_type' => 1,
        //             'address' => $faker->streetAddress,
        //             'country_id' => $mailing_country_id
        //         ],
        //         $permanent_address_id => [
        //             'address_type' => 0,
        //             'address' => $faker->address,
        //             'country_id' => $permanent_country_id
        //         ]]);

        //     $app->wishes()->sync($wish_ids);
        // });

        $application = Application::create([ // user -> rok.zidarn@gmail.com
            'user_id' => 9,
            'application_interval_id' => 1,
            'middle_school_id' => 9,
            'education_type_id' => 16102,
            'profession_id' => 50103,
            'gender' => "male",
            'date_of_birth' => "1993-04-25T22:00:00.000Z",
            'emso' => 2504993500017,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => null,
            'deleted_at' => null,
            'citizen_id' => 1,
            'graduation_type_id' => 1,
            'status' => "filed",
            'district_id' => 61,
            'country_id' => 705,
            'phone' => 051257356
        ]);

        $permanent = ApplicationCity::create([
            'application_id' => $application->id,
            'city_id' => 1000,
            'address' => "Slovenska cesta 1",
            'address_type' => 0,
            'country_id' => 705,
            'created_at' => \Carbon\Carbon::now()
        ]);

        $mailing = ApplicationCity::create([
            'application_id' => $application->id,
            'city_id' => 1000,
            'address' => "Slovenska cesta 2",
            'address_type' => 1,
            'country_id' => 705,
            'created_at' => \Carbon\Carbon::now()
        ]);

        $wish1 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "ZE10",
            'status' => 0,
            'choice_number' => 1
        ]);

        $wish2 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "ZE20",
            'status' => 0,
            'choice_number' => 2
        ]);

        $wish3 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "ZE30",
            'status' => 0,
            'choice_number' => 3
        ]);

        $application = Application::create([ // user -> luka.zidarn@gmail.com
            'user_id' => 10,
            'application_interval_id' => 1,
            'middle_school_id' => 9,
            'education_type_id' => 16102,
            'profession_id' => 57311,
            'gender' => "male",
            'date_of_birth' => "1992-04-25T22:00:00.000Z",
            'emso' => 2504992500017,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => null,
            'deleted_at' => null,
            'citizen_id' => 1,
            'graduation_type_id' => 2,
            'status' => "filed",
            'district_id' => 61,
            'country_id' => 705,
            'phone' => 051257357
        ]);

        $permanent = ApplicationCity::create([
            'application_id' => $application->id,
            'city_id' => 1000,
            'address' => "Slovenska cesta 1",
            'address_type' => 0,
            'country_id' => 705,
            'created_at' => \Carbon\Carbon::now()
        ]);

        $mailing = ApplicationCity::create([
            'application_id' => $application->id,
            'city_id' => 1000,
            'address' => "Slovenska cesta 2",
            'address_type' => 1,
            'country_id' => 705,
            'created_at' => \Carbon\Carbon::now()
        ]);

        $wish1 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "ZE10",
            'status' => 0,
            'choice_number' => 1
        ]);

        $wish2 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "ZE20",
            'status' => 0,
            'choice_number' => 2
        ]);

        $wish3 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "ZE30",
            'status' => 0,
            'choice_number' => 3
        ]);
    }
}
