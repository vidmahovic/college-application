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
        $this->call('RolesTableSeeder');
        $this->call('FacultyTableSeeder');
        $this->call('UsersTableSeeder');
        $this->call('ApplicationIntervalSeeder');
        //$this->call('NationalityTypeSeeder');
        $this->call('FacultyProgramsSeeder');
        $this->call('DistrictsTableSeeder');
        $this->call('UniversityTableSeeder');
        //$this->call('ApplicationsProgramsTableSeeder');
        $this->call('CitiesTableSeeder');
        $this->call('CitizensTableSeeder');
        $this->call('GraduationTypeTableSeeder');
        $this->call('ProfessionsTableSeeder');
        $this->call('CountriesTableSeeder');
        $this->call('MiddleSchoolsTableSeeder');
        $this->call('EducationTypeTableSeeder');
        $this->call('SubjectTableSeeder');
        $this->call('EnrollmentConditionSeeder');
        $this->call('ApplicationTableSeeder');
        $this->call('AbilityTestTableSeeder');
        $this->call('GradesTableSeeder');
    }
}
