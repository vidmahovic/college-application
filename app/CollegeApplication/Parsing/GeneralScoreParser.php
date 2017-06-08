<?php

namespace CollegeApplication\Parsing;

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
        $line['interval_id'] = ApplicationInterval::current()->first()->id;

        switch($line['status']) {
            case 0: case 1: case 2:
                MaturaScore::create($line);
                $this->created_lines++;
                break;
            case 3: case 4:
                $score = MaturaScore::where('emso', $line['emso'])->first();
                if($score === null)
                    MaturaScore::create($line);
                else
                    $score->update(array_except($line, ['emso']));

                $this->updated_lines++;
                break;
            case 7:
                // Store new general matura score, but only emso, first_name, last_name and general_matura bool
                $line['general_matura'] = null;
                MaturaScore::create(array_only($line, ['emso', 'first_name', 'last_name', 'general_matura']));
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
