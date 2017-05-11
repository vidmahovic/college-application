<?php

use App\Models\EducationType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class EducationTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EducationType::create(array(
            "id" => 12001,
            "name" => "Osnovnošolska izobrazba",
            "level" => "1",
            "graduation_type" => "Zaključena osnovna šola, nedokončana osnovna šola"
        ));

        EducationType::create(array(
            "id" => 13001,
            "name" => "Nižja poklicna izobrazba",
            "level" => "3",
            "graduation_type" => "Zaključni izpit"
        ));

        EducationType::create(array(
            "id" => 14001,
            "name" => "Srednja poklicna izobrazba",
            "level" => "4",
            "graduation_type" => "Zaključni izpit"
        ));

        EducationType::create(array(
            "id" => 15001,
            "name" => "Srednja strokovna izobrazba",
            "level" => "5",
            "graduation_type" => "Poklicna matura, zaključni izpit"
        ));

        EducationType::create(array(
            "id" => 15002,
            "name" => "Srednja splošna izobrazba",
            "level" => "5",
            "graduation_type" => "Splošna matura"
        ));

        EducationType::create(array(
            "id" => 16102,
            "name" => "Višješolska izobrazba, predbolonjska",
            "level" => "6/1",
            "graduation_type" => "Inženir, tehnolog, drugo"
        ));

        EducationType::create(array(
            "id" => 16201,
            "name" => "Specializacija po višješolski izobrazbi, predbolonjska",
            "level" => "6/2",
            "graduation_type" => "Diplomirani inženir"
        ));

        EducationType::create(array(
            "id" => 16202,
            "name" => "Visokošolska strokovna izobrazba, predbolonjska",
            "level" => "6/2",
            "graduation_type" => "Specialist"
        ));

        EducationType::create(array(
            "id" => 17001,
            "name" => "Specializacija po visokošolski strokovni izobrazbi, predbolonjska",
            "level" => "7",
            "graduation_type" => "Specialist"
        ));

        EducationType::create(array(
            "id" => 17002,
            "name" => "Visokošolska univerzitetna izobrazba, predbolonjska",
            "level" => "7",
            "graduation_type" => "Univerzitetni diplomirani inženir, akademski profesor, magister, doktor"
        ));

        EducationType::create(array(
            "id" => 18101,
            "name" => "Specializacija po univerzitetni izobrazbi, predbolonjska",
            "level" => "8/1",
            "graduation_type" => "Specialist"
        ));

        EducationType::create(array(
            "id" => 18102,
            "name" => "Magisterij znanosti, predbolonjska",
            "level" => "8/1",
            "graduation_type" => "Magister znanosti, umetnosti"
        ));

        EducationType::create(array(
            "id" => 18201,
            "name" => "Doktorat znanosti, predbolonjska",
            "level" => "8/2",
            "graduation_type" => "Doktor znanosti"
        ));

        //----

        EducationType::create(array(
            "id" => 16101,
            "name" => "Višja strokovna izobrazba",
            "level" => "6/1",
            "graduation_type" => "Inženir, tehnolog"
        ));

        EducationType::create(array(
            "id" => 16203,
            "name" => "Visokošolska strokovna izobrazba, bolonjska",
            "level" => "6/2",
            "graduation_type" => "Diplomirani inženir (VS)"
        ));

        EducationType::create(array(
            "id" => 16204,
            "name" => "Visokošolska univerzitetna izobrazba, 1. bolonjska stopnja",
            "level" => "6/2",
            "graduation_type" => "Diplomirani inženir"
        ));

        EducationType::create(array(
            "id" => 17003,
            "name" => "Magistrka izobrazba, 2. bolonjska stopnja",
            "level" => "7",
            "graduation_type" => "Magister znanosti"
        ));

        EducationType::create(array(
            "id" => 18202,
            "name" => "Doktorat znanosti, 3. bolonjska stopnja",
            "level" => "8/2",
            "graduation_type" => "Doktor znanosti"
        ));
    }
}
