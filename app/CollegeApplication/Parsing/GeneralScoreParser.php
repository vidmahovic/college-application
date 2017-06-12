<?php

namespace CollegeApplication\Parsing;

use App\Models\Application;
use App\Models\ApplicationInterval;
use App\Models\MaturaScore;
use Illuminate\Validation\Rule;

/**
 * Class GeneralScoreParser
 *
 * @package \CollegeApplication\Parsing
 */
class GeneralScoreParser extends MaturaFileParser
{

    protected function parseLine(string $line): array
    {
        return array_combine($this->columns(), array_map('trim', explode('Q', $line)));
    }

    protected function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'emso' => 'required|size:13',
            'matura_points' => 'required_with:matura_done,third_grade_mark,fourth_grade_mark|numeric|min:0|max:34',
            'matura_done' => ['required_with:matura_points,third_grade_mark,fourth_grade_mark', Rule::in(['D', 'N'])],
            'third_grade_mark' => 'required_with:matura_points,matura_done,fourth_grade_mark|numeric|min:2|max:5',
            'fourth_grade_mark' => 'required_with:matura_points_matura_done,third_grade_mark|numeric|min:2|max:5',
            'profession_id' => 'required|exists:professions,id',
            'middle_school_id' => 'required|exists:middle_schools,id',
            'status' => 'required|numeric|min:0|max:9'
        ];
    }

    protected function storeLine(array $line)
    {
        $line['general_matura'] = true;
//        $line['interval_id'] = ApplicationInterval::current()->first()->id;

        $application = Application::firstOrNew(['emso' => $line['emso']]);
        $application->emso = $line['emso'];
        //$application->name = $line['first_name'] . ' ' . $line['last_name'];
        $application->profession_id = $line['profession_id'];
        $application->middle_school_id = $line['middle_school_id'];
        $application->application_interval_id = ApplicationInterval::current()->first()->id;
        $application->save();

        $score = $application->maturaScores()->first();

        switch($line['status']) {
            case 0: case 1: case 2:
                $application->maturaScores()->create($line);
                $this->created_lines++;
                break;
            case 3: case 4:
                if($score === null)
                    $application->maturaScores()->create($line);
                else
                    $score->update(array_except($line, ['emso']));

                $this->updated_lines++;
                break;
            case 7:
                if($score === null) {
                    // This is set to null so the app won't delete records,
                    // imported from general matura scores in vocational matura scores.
                    $line['general_matura'] = null;
                    $application->maturaScores()->create(array_only($line, ['general_matura']));
                }

                break;
        }
    }

    private function columns()
    {
        return [
            'emso', 'first_name', 'last_name', 'matura_points', 'matura_done', 'third_grade_mark',
            'fourth_grade_mark', 'status', 'middle_school_id', 'profession_id'
        ];
    }

    private function formatErrorAttributes(array $attributes) {
        return array_only($attributes, ['emso', 'first_name', 'last_name']);
    }

}
