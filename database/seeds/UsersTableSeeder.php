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

        // CALCULATION TESTS

        // --- id = 9
        User::create([
            'email' => 'rok.zidarn@gmail.com',
            'name' => 'Rok Zidarn',
            'username' => 'rokzidarn',
            'password' => bcrypt('rokzidarn9'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        // --- id = 10
        User::create([
            'email' => 'miha.mihic@gmail.com',
            'name' => 'Miha Mihič',
            'username' => 'mihamihic',
            'password' => bcrypt('mihamihic10'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        // --- id = 11
        User::create([
            'email' => 'bozidar.daribozic@gmail.com',
            'name' => 'Božidar Daribožič',
            'username' => 'bozidardaribozic',
            'password' => bcrypt('bozidardaribozic11'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        // --- id = 12
        User::create([
            'email' => 'karolina.travnikar@gmail.com',
            'name' => 'Karolina Travnikar',
            'username' => 'karolinatravnikar',
            'password' => bcrypt('karolinatravnikar12'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        // --- id = 13
        User::create([
            'email' => 'janez.novak@gmail.com',
            'name' => 'Janez Novak',
            'username' => 'janeznovak',
            'password' => bcrypt('janeznovak13'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        // --- id = 14
        User::create([
            'email' => 'metka.jankec@gmail.com',
            'name' => 'Metka Jankec',
            'username' => 'metkajankec',
            'password' => bcrypt('metkajankec14'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        // --- id = 15
        User::create([
            'email' => 'mirko.ojojoj@gmail.com',
            'name' => 'Mirko Ojojoj',
            'username' => 'mirkoojojoj',
            'password' => bcrypt('mirkoojojoj15'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);


        // "REAL" CANDIDATES


        User::create([
            'email' => 'mihael.novak@gmail.com',
            'name' => 'Mihael Novak',
            'username' => 'mihael.novak',
            'password' => bcrypt('novak1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'peter.planinsek@gmail.com',
            'name' => 'Peter Planinšek',
            'username' => 'peter.planinsek',
            'password' => bcrypt('planinsek1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'stanko.kocjancic@gmail.com',
            'name' => 'Stanko Kocjančič',
            'username' => 'stanko.kocjancic',
            'password' => bcrypt('kocjancic1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'petra.petek@gmail.com',
            'name' => 'Petra Petek',
            'username' => 'petra.petek',
            'password' => bcrypt('petek1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'vida.sedmak@gmail.com',
            'name' => 'Vida Sedmak',
            'username' => 'vida.sedmak',
            'password' => bcrypt('sedmak1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'bernarda.bensa@gmail.com',
            'name' => 'Bernarda Bensa',
            'username' => 'bernarda.bensa',
            'password' => bcrypt('bensa1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'bojan.bojec@gmail.com',
            'name' => 'Bojan Bojec',
            'username' => 'bojan.bojec',
            'password' => bcrypt('bojec1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'bojana.bojec@gmail.com',
            'name' => 'Bojana Bojec',
            'username' => 'bojana.bojec',
            'password' => bcrypt('bojec1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'nives.bokal@gmail.com',
            'name' => 'Nives Bokal',
            'username' => 'nives.bokal',
            'password' => bcrypt('bokal1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'jadran.jernejcic@gmail.com',
            'name' => 'Jadran Jernejčič',
            'username' => 'jadran.jernejcic',
            'password' => bcrypt('jernejcic1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'jernej.jerancic@gmail.com',
            'name' => 'Jernej Jerančič',
            'username' => 'bojana.bojec',
            'password' => bcrypt('jerancic1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'fani.novak@gmail.com',
            'name' => 'Fani Novak',
            'username' => 'fani.novak',
            'password' => bcrypt('novak1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'marjana.jelincic@gmail.com',
            'name' => 'Marjana Viktorija Jelinčič',
            'username' => 'marjana.jelincic',
            'password' => bcrypt('jelincic1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'tomaz.velikonja@gmail.com',
            'name' => 'Tomaž Velikonja',
            'username' => 'tomaz.velikonja',
            'password' => bcrypt('velikonja1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'stefan.stefancic@gmail.com',
            'name' => 'Štefan Štefančič',
            'username' => 'stefan.stefancic',
            'password' => bcrypt('stefancic1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'jana.klinar@gmail.com',
            'name' => 'Jana Klinar',
            'username' => 'jana.klinar',
            'password' => bcrypt('klinar1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'mira.juhant@gmail.com',
            'name' => 'Mira Varl Juhant',
            'username' => 'mira.juhant',
            'password' => bcrypt('juhant1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'stanislav.stanic@gmail.com',
            'name' => 'Stanislav Stanič',
            'username' => 'stanislav.stanic',
            'password' => bcrypt('stanic1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'primoz.primozic@gmail.com',
            'name' => 'Primož Primožič',
            'username' => 'primoz.primozic',
            'password' => bcrypt('primozic1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'anita.cebokli@gmail.com',
            'name' => 'Anita Čebokli',
            'username' => 'anita.cebokli',
            'password' => bcrypt('cebokli1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'klemen.klemencic@gmail.com',
            'name' => 'Klemen Klemenčič',
            'username' => 'klemen.klemencic',
            'password' => bcrypt('klemencic1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'ivan.invancic@gmail.com',
            'name' => 'Ivan Ivančič',
            'username' => 'ivan.ivancic',
            'password' => bcrypt('ivancic1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'pavla.pavlin@gmail.com',
            'name' => 'Pavla Pavlin',
            'username' => 'pavla.pavlin',
            'password' => bcrypt('pavlin1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'pavel.pavlin@gmail.com',
            'name' => 'Pavel Pavlin',
            'username' => 'pavel.pavlin',
            'password' => bcrypt('pavlin1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'bozidar.bozic@gmail.com',
            'name' => 'Božidar Božič',
            'username' => 'bozidar.bozic',
            'password' => bcrypt('bozic1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

        User::create([
            'email' => 'cita.jansa@gmail.com',
            'name' => 'Cita Janša',
            'username' => 'cita.jansa',
            'password' => bcrypt('jansa1234'),
            'activated_at' => Carbon::now(),
            'role_id' => 4
        ]);

    }

}
