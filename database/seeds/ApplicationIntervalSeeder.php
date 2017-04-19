<?php

use Illuminate\Database\Seeder;

/**
 * Class ApplicationIntervalSeeder
 *
 * @package \\${NAMESPACE}
 */
class ApplicationIntervalSeeder extends Seeder
{
    public function run()
    {
        $end = new \Carbon\Carbon('first day of october');
        $start = (new \Carbon\Carbon('first day of october'))->subYear();

        \App\Models\ApplicationInterval::create([
            'starts_at' => $start,
            'ends_at' => $end,
        ]);
    }
}
