<?php

use App\User;
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

        $application = Application::create([ // 8 - user -> Anita Čebokli
            'user_id' => User::where('email', '=', 'anita.cebokli@gmail.com')->first()->id,
            'application_interval_id' => 1,
            'middle_school_id' => 46001,
            'education_type_id' => 15002,
            'profession_id' => 58801,
            'gender' => "female",
            'date_of_birth' => "1997-04-06",
            'emso' => '0604997505029',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => null,
            'deleted_at' => null,
            'citizen_id' => 1,
            'graduation_type_id' => 2,
            'status' => "filed",
            'district_id' => 61,
            'country_id' => 705,
            'phone' => '041251307'
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
            'faculty_program_id' => "VU00",
            'status' => 0,
            'choice_number' => 1
        ]);
        $wish2 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "R400",
            'status' => 0,
            'choice_number' => 2
        ]);
        $wish3 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "SE00",
            'status' => 0,
            'choice_number' => 3
        ]);

        $application = Application::create([ // 9 - user -> Primož Primožič
            'user_id' => User::where('email', '=', 'primoz.primozic@gmail.com')->first()->id,
            'application_interval_id' => 1,
            'middle_school_id' => 39001,
            'education_type_id' => 15002,
            'profession_id' => 51001,
            'gender' => "male",
            'date_of_birth' => "1997-04-06",
            'emso' => '0604997500124',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => null,
            'deleted_at' => null,
            'citizen_id' => 1,
            'graduation_type_id' => 2,
            'status' => "filed",
            'district_id' => 61,
            'country_id' => 705,
            'phone' => '041251307'
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
            'faculty_program_id' => "VU00",
            'status' => 0,
            'choice_number' => 1
        ]);
        $wish2 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "SE00",
            'status' => 0,
            'choice_number' => 2
        ]);
        $wish3 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "R400",
            'status' => 0,
            'choice_number' => 3
        ]);

        $application = Application::create([
            'user_id' => User::where('email', '=', 'jernej.jerancic@gmail.com')->first()->id,
            'application_interval_id' => 1,
            'middle_school_id' => 25002,
            'education_type_id' => 15002,
            'profession_id' => 59931,
            'gender' => "male",
            'date_of_birth' => "1997-07-26",
            'emso' => '2607997500082',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => null,
            'deleted_at' => null,
            'citizen_id' => 1,
            'graduation_type_id' => 1,
            'status' => "filed",
            'district_id' => 61,
            'country_id' => 705,
            'phone' => '041251307'
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
            'faculty_program_id' => "SZ00",
            'status' => 0,
            'choice_number' => 2
        ]);
        $wish3 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "R400",
            'status' => 0,
            'choice_number' => 3
        ]);

        $application = Application::create([
            'user_id' => User::where('email', '=', 'vida.sedmak@gmail.com')->first()->id,
            'application_interval_id' => 1,
            'middle_school_id' => 27007,
            'education_type_id' => 15002,
            'profession_id' => 59911,
            'gender' => "female",
            'date_of_birth' => "1997-12-12",
            'emso' => '1212997505019',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => null,
            'deleted_at' => null,
            'citizen_id' => 1,
            'graduation_type_id' => 1,
            'status' => "filed",
            'district_id' => 61,
            'country_id' => 705,
            'phone' => '041251307'
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
            'faculty_program_id' => "VV00",
            'status' => 0,
            'choice_number' => 2
        ]);
        $wish3 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "TH00",
            'status' => 0,
            'choice_number' => 3
        ]);

        $application = Application::create([
            'user_id' => User::where('email', '=', 'stanislav.stanic@gmail.com')->first()->id,
            'application_interval_id' => 1,
            'middle_school_id' => 39001,
            'education_type_id' => 15002,
            'profession_id' => 51001,
            'gender' => "male",
            'date_of_birth' => "1997-06-06",
            'emso' => '0606997500097',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => null,
            'deleted_at' => null,
            'citizen_id' => 1,
            'graduation_type_id' => 2,
            'status' => "filed",
            'district_id' => 61,
            'country_id' => 705,
            'phone' => '041251307'
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
            'faculty_program_id' => "SE00",
            'status' => 0,
            'choice_number' => 1
        ]);
        $wish2 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "VT00",
            'status' => 0,
            'choice_number' => 2
        ]);
        $wish3 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "R400",
            'status' => 0,
            'choice_number' => 3
        ]);

        $application = Application::create([
            'user_id' => User::where('email', '=', 'peter.planinsek@gmail.com')->first()->id,
            'application_interval_id' => 1,
            'middle_school_id' => 25002,
            'education_type_id' => 15002,
            'profession_id' => 59931,
            'gender' => "male",
            'date_of_birth' => "1997-12-12",
            'emso' => '1212997500017',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => null,
            'deleted_at' => null,
            'citizen_id' => 1,
            'graduation_type_id' => 1,
            'status' => "filed",
            'district_id' => 61,
            'country_id' => 705,
            'phone' => '041251307'
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
            'faculty_program_id' => "VV00",
            'status' => 0,
            'choice_number' => 2
        ]);
        $wish3 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "TH00",
            'status' => 0,
            'choice_number' => 3
        ]);

        $application = Application::create([
            'user_id' => User::where('email', '=', 'cita.jansa@gmail.com')->first()->id,
            'application_interval_id' => 1,
            'middle_school_id' => 36005,
            'education_type_id' => 15002,
            'profession_id' => 56603,
            'gender' => "female",
            'date_of_birth' => "1998-01-02",
            'emso' => '0201998505033',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => null,
            'deleted_at' => null,
            'citizen_id' => 1,
            'graduation_type_id' => 2,
            'status' => "filed",
            'district_id' => 61,
            'country_id' => 705,
            'phone' => '041251307'
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
            'faculty_program_id' => "VU00",
            'status' => 0,
            'choice_number' => 2
        ]);

        $application = Application::create([
            'user_id' => User::where('email', '=', 'bojan.bojec@gmail.com')->first()->id,
            'application_interval_id' => 1,
            'middle_school_id' => 25002,
            'education_type_id' => 15002,
            'profession_id' => 59931,
            'gender' => "male",
            'date_of_birth' => "1998-03-03",
            'emso' => '0303998500187',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => null,
            'deleted_at' => null,
            'citizen_id' => 1,
            'graduation_type_id' => 1,
            'status' => "filed",
            'district_id' => 61,
            'country_id' => 705,
            'phone' => '041251307'
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
            'faculty_program_id' => "VT00",
            'status' => 0,
            'choice_number' => 2
        ]);

        $application = Application::create([
            'user_id' => User::where('email', '=', 'stefan.stefancic@gmail.com')->first()->id,
            'application_interval_id' => 1,
            'middle_school_id' => 25002,
            'education_type_id' => 15002,
            'profession_id' => 52551,
            'gender' => "male",
            'date_of_birth' => "1997-07-06",
            'emso' => '0607997500093',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => null,
            'deleted_at' => null,
            'citizen_id' => 1,
            'graduation_type_id' => 2,
            'status' => "filed",
            'district_id' => 61,
            'country_id' => 705,
            'phone' => '041251307'
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

        $application = Application::create([
            'user_id' => User::where('email', '=', 'tomaz.velikonja@gmail.com')->first()->id,
            'application_interval_id' => 1,
            'middle_school_id' => 25002,
            'education_type_id' => 15002,
            'profession_id' => 52551,
            'gender' => "male",
            'date_of_birth' => "1997-07-16",
            'emso' => '1607997500097',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => null,
            'deleted_at' => null,
            'citizen_id' => 1,
            'graduation_type_id' => 2,
            'status' => "filed",
            'district_id' => 61,
            'country_id' => 705,
            'phone' => '041251307'
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

        $application = Application::create([
        'user_id' => User::where('email', '=', 'mihael.novak@gmail.com')->first()->id,
        'application_interval_id' => 1,
        'middle_school_id' => 28003,
        'education_type_id' => 15002,
        'profession_id' => 59911,
        'gender' => "male",
        'date_of_birth' => "1994-12-12",
        'emso' => '1212994500008',
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => null,
        'deleted_at' => null,
        'citizen_id' => 1,
        'graduation_type_id' => 1,
        'status' => "filed",
        'district_id' => 61,
        'country_id' => 705,
        'phone' => '041251307'
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
            'faculty_program_id' => "VV00",
            'status' => 0,
            'choice_number' => 2
        ]);
        $wish3 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "R400",
            'status' => 0,
            'choice_number' => 3
        ]);


        $application = Application::create([
            'user_id' => User::where('email', '=', 'stanko.kocjancic@gmail.com')->first()->id,
            'application_interval_id' => 1,
            'middle_school_id' => 26001,
            'education_type_id' => 15002,
            'profession_id' => 59911,
            'gender' => "male",
            'date_of_birth' => "1997-12-02",
            'emso' => '0212997500013',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => null,
            'deleted_at' => null,
            'citizen_id' => 1,
            'graduation_type_id' => 1,
            'status' => "filed",
            'district_id' => 61,
            'country_id' => 705,
            'phone' => '041251307'
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
            'faculty_program_id' => "SE00",
            'status' => 0,
            'choice_number' => 1
        ]);
        $wish2 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "R400",
            'status' => 0,
            'choice_number' => 2
        ]);
        $wish3 = ApplicationsPrograms::create([
            'application_id' => $application->id,
            'faculty_program_id' => "VT00",
            'status' => 0,
            'choice_number' => 3
        ]);

        $application = Application::create([
            'user_id' => User::where('email', '=', 'petra.petek@gmail.com')->first()->id,
            'application_interval_id' => 1,
            'middle_school_id' => 46001,
            'education_type_id' => 15002,
            'profession_id' => 59911,
            'gender' => "female",
            'date_of_birth' => "1997-12-02",
            'emso' => '0212997505015',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => null,
            'deleted_at' => null,
            'citizen_id' => 1,
            'graduation_type_id' => 1,
            'status' => "filed",
            'district_id' => 61,
            'country_id' => 705,
            'phone' => '041251307'
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

    }




}
