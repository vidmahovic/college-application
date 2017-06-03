<?php

namespace App\Http\Controllers\Api;

use App\Models\Application;
use App\Models\ApplicationsPrograms;
use App\Models\EnrollmentCondition;
use Dingo\Api\Http\Request;


class CalculationController extends ApiController
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function calculate($id)
    {
        $application = Application::with('wishes', 'applicationsPrograms', 'grades')->find($id);

        $programIds = [];
        $programConditions = [];
        $wishIds = [];

        for($i = 0; $i < count($application->wishes); $i = $i + 1){
            $programId = $application->wishes[$i]["id"];
            array_push($programIds, $programId);
            array_push($wishIds, $application->applicationsPrograms[$i]["id"]);
            $condition = EnrollmentCondition::where('faculty_program_id', $programId)->get(); // TODO: ->whereIn('type', [0,1])
            array_push($programConditions, $condition);
        }

        $grades = $application->grades;

        $types = [0 => 'Splošna in poklicna matura', 1 => 'Splošna matura', 2 => 'Poklicna matura'];
        $names = [0 =>'Uspeh na maturi', 1 => 'Uspeh v 3. in 4. letniku', 2 => 'Uspeh pri dodatnem predmetu',
            3 => 'Uspeh pri predpisanem predmetu', 4 => 'Uspeh pri preizkusu nadarjenosti', 5 => 'Poklic'];

        $uspeh3L = 3;
        $uspeh4L = 4;

        for($i = 0; $i < count($programConditions); $i = $i + 1){ // wish
            $points = 0;
            $failedCondition = false;
            for($j = 0; $j < count($programConditions[$i]); $j = $j + 1){ // condition of certain wish
                $condition = $programConditions[$i][$j];
                switch($condition["name"]) {
                    case 0:

                        break;
                    case 1:
                        if($uspeh3L > 1 && $uspeh3L < 6 && $uspeh4L > 1 && $uspeh4L < 6){
                            $uspeh34L = ($uspeh3L + $uspeh3L) * 10;
                            $points = $points + ($uspeh34L * ($condition["weight"] / 100));
                        }
                        else {
                            $failedCondition = true;
                        }
                        break;
                    case 2:

                        break;
                    case 3:

                        break;
                    case 4:

                        break;
                    case 5:

                        break;
                }
            }
            $applicationProgram = ApplicationsPrograms::find($wishIds[$i]);
            if(!$failedCondition) {
                $applicationProgram->points = $points;
            }
            else{
                $applicationProgram->points = -1;
            }
            $applicationProgram->save;
        }

        return $application;
    }

    public static function gradeTable(){
        $length = 25;

        $splosnaMatura = []; // 34
        for($i = 10; $i <= 34; $i = $i + 1){
            array_push($splosnaMatura, $i);
        }

        $poklicnaMatura = []; // 23
        array_push($poklicnaMatura, 8,9,10,10,11,12,13,14,14,15,16,17,18,18);
        array_push($poklicnaMatura, 19,19,19,20,20,21,21,22,22,23,23);

        $lestvica28 = [];
        array_push($lestvica28, 2,3,3,3,4,4,5,5,5,6,6,7,7,7,8,8,8,8,8,8,8,8,8,8,8);

        $lestvica25 = [];
        array_push($lestvica25, 2,3,3,3,3,3,4,4,4,4,4,5,5,5,5,5,5,5,5,5,5,5,5,5,5);

        $gradeTable = [];
        $gradeTable["splosnaMatura"] = $splosnaMatura;
        $gradeTable["poklicnaMatura"] = $poklicnaMatura;
        $gradeTable["lestvica28"] = $lestvica28;
        $gradeTable["lestvica25"] = $lestvica25;

        return $gradeTable;
    }
}