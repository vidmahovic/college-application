<?php

namespace CollegeApplication\Parsing;

use Illuminate\Validation\Rule;

/**
 * Class VocationalMaturaParser
 *
 * @package \CollegeApplication\Parsing
 */
class VocationalMaturaParser extends ScoreParser
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
            '3_grade_mark' => 'required|numeric|min:2|max:5',
            '4_grade_mark' => 'required|numeric|min:2|max:5',
            'profession_id' => 'required|exists:professions,id',
            'middle_school_id' => 'required|exists:middle_schools,id',
            'boo' => 'present'
        ];
    }

    private function columns()
    {
        return [
            'emso', 'first_name', 'last_name', 'matura_points', 'matura_done', '3_grade_mark',
            '4_grade_mark', 'boo', 'middle_school_id', 'profession_id'
        ];
    }
}
