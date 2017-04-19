<?php

/**
 * Class NationalityTypeSeeder
 *
 * @package \\${NAMESPACE}
 */
class NationalityTypeSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        \App\Models\NationalityType::create([
            'type' => 1,
            'description' => 'Friendly description'
        ]);
    }
}
