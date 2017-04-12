<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(RolesTableSeeder::class);
        $this->call('UsersTableSeeder');
        $this->call('FacultyProgramsSeeder');
        $this->call('DistrictsTableSeeder');
        $this->call('UniversityTableSeeder');
        $this->call('FacultyTableSeeder');
        $this->call('ApplicationsProgramsTableSeeder');
        $this->call('CitiesTableSeeder');
        $this->call('CitizensTableSeeder');
        $this->call('GraduationTypeTableSeeder');
        $this->call('ProfessionsTableSeeder');
        $this->call('CountriesTableSeeder');
        $this->call('ProfessionsTableSeeder');
        $this->call('MiddleSchoolsTableSeeder');
        $this->call('EducationTypeTableSeeder');
    }
}
