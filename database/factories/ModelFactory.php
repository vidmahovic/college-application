<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
    ];
});

$factory->define(App\Models\Application::class, function(Faker\Generator $faker) {

    $users = \App\User::students()->pluck('id')->shuffle()->toArray();
    $application_interval_ids = \App\Models\ApplicationInterval::pluck('id')->shuffle()->toArray();
    $middle_school_ids = \App\Models\MiddleSchool::pluck('id')->shuffle()->toArray();
    $education_type_ids = \App\Models\EducationType::pluck('id')->shuffle()->toArray();
    $profession_ids = \App\Models\Profession::pluck('id')->shuffle()->toArray();
    //$nationality_type_ids = \App\Models\Nationa::pluck('id')->shuffle()->toArray();
    $graduation_type_ids = \App\Models\GraduationType::pluck('id')->shuffle()->toArray();
    $country_ids = \App\Models\Country::pluck('id')->shuffle()->toArray();
    $district_ids = \App\Models\District::pluck('id')->shuffle()->toArray();
    $citizen_ids = \App\Models\Citizen::pluck('id')->shuffle()->toArray();

    return [
        'user_id' => $users[0],
        'application_interval_id' => $application_interval_ids[0],
        'middle_school_id' => $middle_school_ids[0],
        'education_type_id' => $education_type_ids[0],
        'profession_id' => $profession_ids[0],
        //'nationality_type_id' => null, //$nationality_type_ids[0],
        'graduation_type_id' => $graduation_type_ids[0],
        'country_id' => $country_ids[0],
        'citizen_id' => $citizen_ids[0],
        'district_id' => $district_ids[0],
        //'middle_name' => $faker->randomElement([$faker->name, null, null, null, null]),
        'phone' => $faker->phoneNumber,
        'date_of_birth' => $faker->date('Y-m-d'),
        'emso' => (string) $faker->ean13,
        'gender' => $faker->randomElement(['male', 'female']),
        'status' => $faker->randomElement(['created', 'saved', 'filed'])
    ];
});
