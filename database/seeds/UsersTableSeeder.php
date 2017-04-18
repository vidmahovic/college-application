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
            'username' => 'demo123',
            'password' => app('hash')->make('demo123'),
            'role_id' => 1
        ]);

        User::create([
            'email' => 'student1@student.com',
            'username' => 'student1',
            'password' => app('hash')->make('student1'),
            'role_id' => 3
        ]);

        User::create([
            'email' => 'student2@student.com',
            'username' => 'student2',
            'password' => app('hash')->make('student2'),
            'role_id' => 3
        ]);

        User::create([
            'email' => 'student3@student.com',
            'username' => 'student3',
            'password' => app('hash')->make('student3'),
            'role_id' => 3
        ]);



        User::create([
            'email' => 'admin@admin.mail.com',
            'username' => 'admin123',
            'password' => app('hash')->make('admin'),
            'role_id' => 1
        ]);
        

        User::create([
            'email' => 'referent@fri.com',
            'username' => 'referent_fri',
            'password' => app('hash')->make('referentfri'),
            'role_id' => 2
        ]);

        User::create([
            'email' => 'referent@ff.com',
            'username' => 'referent_ff',
            'password' => app('hash')->make('referentff'),
            'role_id' => 2
        ]);
    }

}
