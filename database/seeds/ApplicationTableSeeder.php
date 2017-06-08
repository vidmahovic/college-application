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

        // CALCULATION TESTS

        $application = Application::create([ // 1 - user -> Rok Zidarn (M) - poklic: Gimnazija
            'user_id' => 9,
            'application_interval_id' => 1,
            'middle_school_id' => 9,
            'education_type_id' => 15002,
            'profession_id' => 59911,
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
            'phone' => 051256356
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
            'faculty_program_id' => "SU00",
            'status' => 0,
            'choice_number' => 1
        ]);
        $wish2 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "SG00",
            'status' => 0,
            'choice_number' => 2
        ]);
        $wish3 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "VT00",
            'status' => 0,
            'choice_number' => 3
        ]);

        $application = Application::create([ // 2 - user -> Miha Mihič (PM) - poklic: Gozdarski tehnik
            'user_id' => 10,
            'application_interval_id' => 1,
            'middle_school_id' => 9,
            'education_type_id' => 15001,
            'profession_id' => 51001,
            'gender' => "male",
            'date_of_birth' => "1992-04-25T22:00:00.000Z",
            'emso' => 2404992500017,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => null,
            'deleted_at' => null,
            'citizen_id' => 1,
            'graduation_type_id' => 2,
            'status' => "filed",
            'district_id' => 61,
            'country_id' => 705,
            'phone' => 053257357
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
            'faculty_program_id' => "SU00",
            'status' => 0,
            'choice_number' => 1
        ]);
        $wish2 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "SG00",
            'status' => 0,
            'choice_number' => 2
        ]);
        $wish3 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "VU00",
            'status' => 0,
            'choice_number' => 3
        ]);

        $application = Application::create([ // 3 - user -> Božidar Daribožič (M)
            'user_id' => 11,
            'application_interval_id' => 1,
            'middle_school_id' => 9,
            'education_type_id' => 15002,
            'profession_id' => 59911,
            'gender' => "male",
            'date_of_birth' => "1992-04-25T22:00:00.000Z",
            'emso' => 2304992500017,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => null,
            'deleted_at' => null,
            'citizen_id' => 1,
            'graduation_type_id' => 1,
            'status' => "filed",
            'district_id' => 61,
            'country_id' => 705,
            'phone' => 051356356
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
            'faculty_program_id' => "R400",
            'status' => 0,
            'choice_number' => 1
        ]);
        $wish2 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "SD00",
            'status' => 0,
            'choice_number' => 2
        ]);

        $application = Application::create([ // 4 - user -> Karolina Travnikar (PM)
            'user_id' => 12,
            'application_interval_id' => 1,
            'middle_school_id' => 9,
            'education_type_id' => 15001,
            'profession_id' => 51001,
            'gender' => "female",
            'date_of_birth' => "1992-04-25T22:00:00.000Z",
            'emso' => 2604993500017,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => null,
            'deleted_at' => null,
            'citizen_id' => 1,
            'graduation_type_id' => 2,
            'status' => "filed",
            'district_id' => 61,
            'country_id' => 705,
            'phone' => 051257307
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
            'faculty_program_id' => "SZ00",
            'status' => 0,
            'choice_number' => 1
        ]);
        $wish2 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "TH00",
            'status' => 0,
            'choice_number' => 2
        ]);
        $wish3 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "R400",
            'status' => 0,
            'choice_number' => 3
        ]);

        $application = Application::create([ // 5 - user -> Janez Novak (M)
            'user_id' => 13,
            'application_interval_id' => 1,
            'middle_school_id' => 9,
            'education_type_id' => 15002,
            'profession_id' => 59911,
            'gender' => "male",
            'date_of_birth' => "1992-04-25T22:00:00.000Z",
            'emso' => 2608993500017,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => null,
            'deleted_at' => null,
            'citizen_id' => 1,
            'graduation_type_id' => 1,
            'status' => "filed",
            'district_id' => 61,
            'country_id' => 705,
            'phone' => 041257357
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
            'faculty_program_id' => "SZ00",
            'status' => 0,
            'choice_number' => 1
        ]);
        $wish2 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "SD00",
            'status' => 0,
            'choice_number' => 2
        ]);
        $wish3 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "VV00",
            'status' => 0,
            'choice_number' => 3
        ]);

        $application = Application::create([ // 6 - user -> Metka Jankec (PM)
            'user_id' => 14,
            'application_interval_id' => 1,
            'middle_school_id' => 9,
            'education_type_id' => 15001,
            'profession_id' => 57311,
            'gender' => "female",
            'date_of_birth' => "1992-04-25T22:00:00.000Z",
            'emso' => 2608993500017,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => null,
            'deleted_at' => null,
            'citizen_id' => 1,
            'graduation_type_id' => 2,
            'status' => "filed",
            'district_id' => 61,
            'country_id' => 705,
            'phone' => 041251357
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
            'faculty_program_id' => "VT00",
            'status' => 0,
            'choice_number' => 1
        ]);
        $wish2 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "VU00",
            'status' => 0,
            'choice_number' => 2
        ]);
        $wish3 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "TH00",
            'status' => 0,
            'choice_number' => 3
        ]);

        $application = Application::create([ // 7 - user -> Mirko Ojojoj (NM) - matura: Neznana matura
            'user_id' => 15,
            'application_interval_id' => 1,
            'middle_school_id' => 9,
            'education_type_id' => 15002,
            'profession_id' => 59911,
            'gender' => "male",
            'date_of_birth' => "1992-04-25T22:00:00.000Z",
            'emso' => 1608993500017,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => null,
            'deleted_at' => null,
            'citizen_id' => 0,
            'graduation_type_id' => 0,
            'status' => "filed",
            'district_id' => 0,
            'country_id' => 999,
            'phone' => 041251307
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
            'faculty_program_id' => "VT00",
            'status' => 0,
            'choice_number' => 1
        ]);
        $wish2 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "TH00",
            'status' => 0,
            'choice_number' => 2
        ]);
        $wish3 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "R400",
            'status' => 0,
            'choice_number' => 3
        ]);
    }
}
