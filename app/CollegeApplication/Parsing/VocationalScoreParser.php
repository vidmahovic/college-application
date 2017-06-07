<?php

namespace CollegeApplication\Parsing;

use App\Models\ApplicationInterval;
use App\Models\MaturaScore;
use Illuminate\Validation\Rule;

/**
 * Class VocationalScoreParser
 *
 * @package \CollegeApplication\Parsing
 */
class VocationalScoreParser extends MaturaFileParser
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
            'matura_points' => 'required|numeric|min:0|max:23',
            'matura_done' => ['required', Rule::in(['D', 'N'])],
            'third_grade_mark' => 'required|numeric|min:2|max:5',
            'fourth_grade_mark' => 'required|numeric|min:2|max:5',
            'profession_id' => 'required|exists:professions,id',
            'middle_school_id' => 'required|exists:middle_schools,id',
            'status' => 'required|numeric|min:1|max:7'
        ];
    }

    protected function storeLine(array $line)
    {
        $line['general_matura'] = false;
        $line['interval_id'] = ApplicationInterval::current()->first()->id;

        $score = MaturaScore::where('emso', $line['emso'])->first();
        if($score === null)
             MaturaScore::create($line);
        else
            $score->update(array_except($line, ['emso']));

        switch($line['status']) {
            case 1:
                $this->created_lines++;
                break;
            case 2 : case 3: case 4: case 6:
                $this->updated_lines++;
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
}
