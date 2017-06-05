<?php

namespace CollegeApplication\Parsing;

use Illuminate\Validation\Rule;

/**
 * Class GeneralMaturaSubjectsParser
 *
 * @package \CollegeApplication\Parsing
 */
class GeneralMaturaSubjectsParser extends ScoreParser
{

    protected function parseLine(string $line): array
    {
        return array_combine($this->columns(), array_map('trim', explode('Q', $line)));
    }

    protected function rules(): array
    {
        return [
            'emso' => 'required|size:13',
            'subject_id' => 'required|exists:subjects,id',
            'matura_mark' => 'required|numeric|min:1|max:5',
            'matura_done' => ['required_with:3_grade_mark,4_grade_mark', Rule::in(['D', 'N'])],
            '3_grade_mark' => 'required_with:matura_done,4_grade_mark|numeric|min:2|max:5',
            '4_grade_mark' => 'required_with:matura_done,3_grade_mark|numeric|min:2|max:5',
            'boo' => 'present'
        ];
    }

    private function columns(): array
    {
        return [
            'emso', 'subject_id', 'matura_mark', '3_grade_mark', '4_grade_mark', 'matura_done', 'boo'
        ];
    }
}
