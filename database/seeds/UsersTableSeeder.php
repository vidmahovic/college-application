<?php

use App\Models\Faculty;
use App\User;
use Carbon\Carbon;
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
            'password' => bcrypt('demo1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 1
        ]);

        User::create([
            'email' => 'student1@student.com',
            'username' => 'student1',
            'password' => bcrypt('student1'),
            'activated_at' => Carbon::now(),
            'name' => 'Marko Novak',
            'role_id' => 4
        ]);

        User::create([
            'email' => 'student2@student.com',
            'username' => 'student2',
            'password' => bcrypt('student2'),
            'activated_at' => Carbon::now(),
            'name' => 'Janez Kranjski',
            'role_id' => 4
        ]);

        User::create([
            'email' => 'student3@student.com',
            'username' => 'student3',
            'password' => bcrypt('student3'),
            'name' => 'Borut Veselko',
            'role_id' => 4
        ]);



        User::create([
            'email' => 'admin@admin.mail.com',
            'username' => 'admin123',
            'password' => bcrypt('admin123'),
            'activated_at' => Carbon::now(),
            'role_id' => 1
        ]);
        

        User::create([
            'email' => 'referent@fri.com',
            'username' => 'referent_fri',
            'password' => bcrypt('referentfri1'),
            'activated_at' => Carbon::now(),
            'faculty_id' => Faculty::where('name', 'like', '%fakulteta za računalništvo%')->first()->id,
            'role_id' => 2
        ]);

        User::create([
            'email' => 'referent@ff.com',
            'username' => 'referent_ff',
            'password' => bcrypt('referentff1'),
            'activated_at' => Carbon::now(),
            'faculty_id' => Faculty::where('name', 'like', '%filozofska%')->first()->id,
            'role_id' => 2
        ]);

        User::create([
            'email' => 'vpisna@sluzba.com',
            'username' => 'enrollment_service',
            'password' => bcrypt('vpisna12'),
            'activated_at' => Carbon::now(),
            'role_id' => 3
        ]);
    }

}
