<?php

use App\User;
use Illuminate\Database\Seeder;

/**
 * Class UsersTableSeeder
 *
 * @package \\${NAMESPACE}
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'demo@demo.com',
            'username' => 'demo',
            'password' => app('hash')->make('demo123')
        ]);
    }

}
