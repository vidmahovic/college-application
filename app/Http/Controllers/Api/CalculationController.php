<?php

namespace App\Http\Controllers\Api;

use App\Models\AbilityTest;
use App\Models\Application;
use App\Models\ApplicationsPrograms;
use App\Models\EnrollmentCondition;
use App\Models\FacultyProgram;
use Dingo\Api\Http\Request;
use Dingo\Api\Exception\ResourceException;

class CalculationController extends ApiController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function index(){
        $applications = Application::with('applicant', 'wishes')->get();

        return $applications;
    }

    public function classifyEU(){
        $faculty_programs = FacultyProgram::has('applicationsPrograms')->get();
        $faculty_program_ids = $faculty_programs->pluck('id')->toArray();
        $faculty_program_available = $faculty_programs->pluck('max_accepted')->toArray();
        $eu = [1,4,5,6];

        for($i = 0; $i < count($faculty_program_ids); $i = $i + 1){
            $wishes1 = ApplicationsPrograms::where('faculty_program_id', $faculty_program_ids[$i])
                ->whereHas('application', function($query) use($eu){
                    $query->whereIn('citizen_id', $eu);
                })->where('choice_number', 1)->where('points', '>', 0)->orderBy('points', 'desc')->get();

            $number_of_applied = count($wishes1);
            if($faculty_program_available[$i] >= $number_of_applied){
                for($j = 0; $j < count($wishes1); $j = $j + 1){
                    $wishes1[$j]->fill(['status' => true]);
                    $wishes1[$j]->save();
                }
                $faculty_program_available[$i] = $faculty_program_available[$i] - $number_of_applied;
            }
            else{
                for($k = 0; $k < count($faculty_program_available); $k = $k + 1){
                    $wishes1[$k]->fill(['status' => true]);
                    $wishes1[$k]->save();
                }
                $faculty_program_available[$i] = 0;
            }

            $wishes2 = ApplicationsPrograms::where('faculty_program_id', $faculty_program_ids[$i])
                ->whereHas('application', function($query) use($eu){
                    $query->whereIn('citizen_id', $eu);
                })->where('choice_number', 2)->where('points', '>', 0)->orderBy('points', 'desc')->get();

            $number_of_applied = count($wishes2);
            if($faculty_program_available[$i] >= $number_of_applied){
                for($j = 0; $j < count($wishes2); $j = $j + 1){
                    $wishes2[$j]->fill(['status' => true]);
                    $wishes2[$j]->save();
                }
                $faculty_program_available[$i] = $faculty_program_available[$i] - $number_of_applied;
            }
            else{
                for($k = 0; $k < count($faculty_program_available); $k = $k + 1){
                    $wishes2[$k]->fill(['status' => true]);
                    $wishes2[$k]->save();
                }
                $faculty_program_available[$i] = 0;
            }

            $wishes3 = ApplicationsPrograms::where('faculty_program_id', $faculty_program_ids[$i])
                ->whereHas('application', function($query) use($eu){
                    $query->whereIn('citizen_id', $eu);
                })->where('choice_number', 3)->where('points', '>', 0)->orderBy('points', 'desc')->get();

            $number_of_applied = count($wishes3);
            if($faculty_program_available[$i] >= $number_of_applied){
                for($j = 0; $j < count($wishes3); $j = $j + 1){
                    $wishes3[$j]->fill(['status' => true]);
                    $wishes3[$j]->save();
                }
                $faculty_program_available[$i] = $faculty_program_available[$i] - $number_of_applied;
            }
            else{
                for($k = 0; $k < count($faculty_program_available); $k = $k + 1){
                    $wishes1[$k]->fill(['status' => true]);
                    $wishes1[$k]->save();
                }
                $faculty_program_available[$i] = 0;
            }
        }

        return ApplicationsPrograms::whereHas('application', function($query) use($eu){
            $query->whereIn('citizen_id', $eu);
        })->with(['application' => function($query) use($eu){
            $query->whereIn('citizen_id', $eu)->with('applicant');
        }])->orderBy('points', 'desc')->get();
    }

    public function classifyForeign(){
        $faculty_programs = FacultyProgram::has('applicationsPrograms')->get();
        $faculty_program_ids = $faculty_programs->pluck('id')->toArray();
        $faculty_program_available = $faculty_programs->pluck('max_accepted_foreign')->toArray();
        $foreign = [0,2,3];

        for($i = 0; $i < count($faculty_program_ids); $i = $i + 1){
            $wishes1 = ApplicationsPrograms::where('faculty_program_id', $faculty_program_ids[$i])
                ->whereHas('application', function($query) use($foreign){
                    $query->whereIn('citizen_id', $foreign);
                })->where('choice_number', 1)->where('points', '>', 0)->orderBy('points', 'desc')->get();

            $number_of_applied = count($wishes1);
            if($faculty_program_available[$i] >= $number_of_applied){
                for($j = 0; $j < count($wishes1); $j = $j + 1){
                    $wishes1[$j]->fill(['status' => true]);
                    $wishes1[$j]->save();
                }
                $faculty_program_available[$i] = $faculty_program_available[$i] - $number_of_applied;
            }
            else{
                for($k = 0; $k < count($faculty_program_available); $k = $k + 1){
                    $wishes1[$k]->fill(['status' => true]);
                    $wishes1[$k]->save();
                }
                $faculty_program_available[$i] = 0;
            }

            $wishes2 = ApplicationsPrograms::where('faculty_program_id', $faculty_program_ids[$i])
                ->whereHas('application', function($query) use($foreign){
                    $query->whereIn('citizen_id', $foreign);
                })->where('choice_number', 2)->where('points', '>', 0)->orderBy('points', 'desc')->get();

            $number_of_applied = count($wishes2);
            if($faculty_program_available[$i] >= $number_of_applied){
                for($j = 0; $j < count($wishes2); $j = $j + 1){
                    $wishes2[$j]->fill(['status' => true]);
                    $wishes2[$j]->save();
                }
                $faculty_program_available[$i] = $faculty_program_available[$i] - $number_of_applied;
            }
            else{
                for($k = 0; $k < count($faculty_program_available); $k = $k + 1){
                    $wishes2[$k]->fill(['status' => true]);
                    $wishes2[$k]->save();
                }
                $faculty_program_available[$i] = 0;
            }

            $wishes3 = ApplicationsPrograms::where('faculty_program_id', $faculty_program_ids[$i])
                ->whereHas('application', function($query) use($foreign){
                    $query->whereIn('citizen_id', $foreign);
                })->where('choice_number', 3)->where('points', '>', 0)->orderBy('points', 'desc')->get();

            $number_of_applied = count($wishes3);
            if($faculty_program_available[$i] >= $number_of_applied){
                for($j = 0; $j < count($wishes3); $j = $j + 1){
                    $wishes3[$j]->fill(['status' => true]);
                    $wishes3[$j]->save();
                }
                $faculty_program_available[$i] = $faculty_program_available[$i] - $number_of_applied;
            }
            else{
                for($k = 0; $k < count($faculty_program_available); $k = $k + 1){
                    $wishes1[$k]->fill(['status' => true]);
                    $wishes1[$k]->save();
                }
                $faculty_program_available[$i] = 0;
            }
        }

        return ApplicationsPrograms::whereHas('application', function($query) use($foreign){
                $query->whereIn('citizen_id', $foreign);
            })->with(['application' => function($query) use($foreign){
                $query->whereIn('citizen_id', $foreign)->with('applicant');
            }])->orderBy('points', 'desc')->get();
    }

    public function calculate($id)
    {
        $application = Application::with('wishes', 'grades')->find($id);

        if($application == null){
            throw new ResourceException('Resource not found');
        }

        $programIds = [];
        $programConditions = [];
        $wishIds = [];

        $grades = $application->grades; // M - matura, L - poklicna matura, S - preizkus sposobnosti
        $graduation_type = $application->graduation_type_id; // 1 - splošna matura,  2 - poklicna matura
        $profession = $application->profession_id;
        $application_ability_test = $application->applicationAbilityTests()->first();
        if(empty($ability_test)){
            $ability_test = null;
        }

        $uspeh3L = 1;
        $uspeh4L = 1;
        $failed = false;

        if(!($graduation_type == 1 || $graduation_type == 2)){
            $failed = true;
        }

        if(count($grades) < 6){
            $failed = true;
        }
        else{
            for($i = 0; $i < count($grades); $i = $i + 1){
                if($grades[$i]["grade"] < 2){
                    $failed = true;
                }
                if($grades[$i]["subject_id"] == 'U003'){
                    $uspeh3L = $grades[$i]["grade"];
                }
                if($grades[$i]["subject_id"] == 'U004'){
                    $uspeh4L = $grades[$i]["grade"];
                }
            }
        }

        $types = [0 => 'Splošna in poklicna matura', 1 => 'Splošna matura', 2 => 'Poklicna matura'];

        for($i = 0; $i < count($application->wishes); $i = $i + 1){
            $programId = $application->wishes[$i]["id"];
            array_push($programIds, $programId);
            array_push($wishIds, $application->applicationsPrograms[$i]["id"]);
            $condition = EnrollmentCondition::where('faculty_program_id', $programId)->whereIn('type', [0, $graduation_type])->get();
            array_push($programConditions, $condition);
        }

        $names = [0 =>'Uspeh na maturi', 1 => 'Uspeh v 3. in 4. letniku', 2 => 'Uspeh pri dodatnem predmetu',
            3 => 'Uspeh pri predpisanem predmetu', 4 => 'Uspeh pri preizkusu nadarjenosti', 5 => 'Poklic'];

        $grade_table = self::gradeTable();
        $high_level_subjects = ['L103', 'L222', 'M222', 'M212', 'M812'];

        for($wish_index = 0; $wish_index < count($wishIds); $wish_index = $wish_index + 1){ // wish
            $wish = $wishIds[$wish_index];
            if($failed){
                $points = -100;
            }
            else {
                $points = 0;
            }
            for($j = 0; $j < count($programConditions[$wish_index]); $j = $j + 1){ // condition of certain wish
                $condition = $programConditions[$wish_index][$j];
                $curr_point = 0;
                switch($condition["name"]) {
                    case 0:
                        $sum = 0;
                        for($i = 0; $i < count($grades); $i = $i + 1){
                            $sid = $grades[$i]["subject_id"];
                            if($sid[0] == 'M' || $sid[0] == 'L'){
                                $sum = $sum + $grades[$i]["grade"];
                            }
                        }

                        if($graduation_type == 1) {
                            $index = array_search($sum, $grade_table["splosnaMatura"]);
                            $curr_point = ($grade_table["koncna"][$index] * ($condition["weight"] / 100));
                            $points = $points + $curr_point;
                        }
                        else{
                            $index = array_search($sum, $grade_table["poklicnaMatura"]);
                            $curr_point = ($grade_table["koncna"][$index] * ($condition["weight"] / 100));
                            $points = $points + $curr_point;
                        }
                        break;
                    case 1:
                        if($uspeh3L > 1 && $uspeh3L < 6 && $uspeh4L > 1 && $uspeh4L < 6){
                            $uspeh34L = ($uspeh3L + $uspeh3L) * 10;
                            $curr_point = ($uspeh34L * ($condition["weight"] / 100));
                            $points = $points + $curr_point;
                        }
                        else {
                            $points = -100;
                        }
                        break;
                    case 2:
                        $general_grades = [];
                        $general_subjects= [];
                        for($k = 0; $k < count($grades); $k = $k + 1){
                            $sid = $grades[$k]["subject_id"];
                            if($sid[0] == 'M'){
                                array_push($general_grades, $grades[$k]["grade"]);
                                array_push($general_subjects, $grades[$k]["subject_id"]);
                            }
                        }
                        if(empty($general_grades)){
                            $points = -100;
                        }
                        else{
                            $max_subject_index = array_keys($general_grades, max($general_grades));
                            if(in_array($general_subjects[intval($max_subject_index[0])], $high_level_subjects)){
                                $grade = self::gradePointHighLevel(max($general_grades));
                            }
                            else {
                                $grade = self::gradePoint(max($general_grades));
                            }
                            $curr_point = ($grade * ($condition["weight"] / 100));
                            $points = $points + $curr_point;
                        }
                        break;
                    case 3:
                        $obligatory = null;
                        for($i = 0; $i < count($grades); $i = $i + 1){
                            $sid = $grades[$i]["subject_id"];
                            if($sid == $condition["conditions_subject_id"]){
                                $obligatory = $grades[$i];
                            }
                        }
                        if($obligatory != null){
                            $grade = 0;
                            if(in_array($obligatory["subject_id"], $high_level_subjects)){
                                $grade = self::gradePointHighLevel($obligatory["grade"]);
                            }
                            else{
                                $grade = self::gradePoint($obligatory["grade"]);
                            }
                            $curr_point = ($grade * ($condition["weight"] / 100));
                            $points = $points + $curr_point;
                        }
                        else {
                            $points = -100;
                        }
                        break;
                    case 4:
                        if($application_ability_test != null){
                            $aid = $application_ability_test->ability_test_id;
                            $test = AbilityTest::where('id', $aid)->first();
                            $score = $application_ability_test->points;
                            $min = $test->min_points;
                            $max = $test->max_points;

                            if($score > $min) {
                                $curr_point = ((40 + 60 * (($score - $min) / ($max - $min)))*($condition["weight"] / 100));
                                $points = $points + $curr_point;
                            }
                            else{
                                $points = -100;
                            }
                        }
                        else {
                            $points = -100;
                        }
                        break;
                    case 5:
                        if($condition["conditions_profession_id"] != $profession){
                            $points = -100;
                        }
                        break;
                }
            }

            $applicationProgram = ApplicationsPrograms::find($wish);
            if($points > 0) {
                $applicationProgram->points = $points;
            }
            else{
                $applicationProgram->points = 0;
            }
            $applicationProgram->save();
        }

        return Application::with('wishes', 'grades', 'applicationAbilityTests')->find($id);
    }

    public static function gradeTable(){
        $length = 25;

        $splosnaMatura = []; // 34
        for($i = 10; $i <= 34; $i = $i + 1){
            array_push($splosnaMatura, $i);
        }
        array_reverse($splosnaMatura);

        $poklicnaMatura = []; // 23
        array_push($poklicnaMatura, 8,9,10,10,11,12,13,14,14,15,16,17,18,18);
        array_push($poklicnaMatura, 19,19,19,20,20,21,21,22,22,23,23);
        array_reverse($poklicnaMatura);

        $lestvica28 = [];
        array_push($lestvica28, 2,3,3,3,4,4,5,5,5,6,6,7,7,7,8,8,8,8,8,8,8,8,8,8,8);
        array_reverse($lestvica28);

        $lestvica25 = [];
        array_push($lestvica25, 2,3,3,3,3,3,4,4,4,4,4,5,5,5,5,5,5,5,5,5,5,5,5,5,5);
        array_reverse($lestvica25);

        $koncna = [];
        array_push($koncna, 40,45,47.5,50,55,60,65,67.5,70,75,80,85,87.5,90,91,92,93,94,95,95.8,96.7,97.5,98.3,99.2,100);
        array_reverse($koncna);

        $gradeTable = [];
        $gradeTable["splosnaMatura"] = $splosnaMatura;
        $gradeTable["poklicnaMatura"] = $poklicnaMatura;
        $gradeTable["lestvica28"] = $lestvica28;
        $gradeTable["lestvica25"] = $lestvica25;
        $gradeTable["koncna"] = $koncna;

        return $gradeTable;
    }

    public static function gradePoint($val){
        $gradePoint = 0;
        switch($val){
            case 2:
                $gradePoint = 40;
                break;
            case 3:
                $gradePoint = 60;
                break;
            case 4:
                $gradePoint = 80;
                break;
            case 5:
                $gradePoint = 100;
                break;
        }
        return $gradePoint;
    }

    public static function gradePointHighLevel($val){
        $gradePoint = 0;
        switch($val){
            case 2:
                $gradePoint = 40;
                break;
            case 3:
                $gradePoint = 50;
                break;
            case 4:
                $gradePoint = 60;
                break;
            case 5:
                $gradePoint = 70;
                break;
            case 6:
                $gradePoint = 80;
                break;
            case 7:
                $gradePoint = 90;
                break;
            case 8:
                $gradePoint = 100;
                break;
        }
        return $gradePoint;
    }
}