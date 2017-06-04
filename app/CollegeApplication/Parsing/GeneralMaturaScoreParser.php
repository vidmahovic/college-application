<?php

namespace CollegeApplication\Parsing;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Rule;

/**
 * Class GeneralMaturaScoreParser
 *
 * @package \App\Parsing
 */
class GeneralMaturaScoreParser extends ScoreParser
{

    /**
     * Parse file line.
     *
     * @param string $line
     * @return array
     */
    protected function parseLine(string $line): array
    {
        return array_combine($this->columns(), array_map('trim', explode('Q', $line)));
    }

    /**
     * Type keys for every column of a line.
     * Order is important.
     *
     * @return array
     */
    private function columns(): array
    {
        return [
            'emso', 'first_name', 'last_name', 'matura_points', 'matura_done', 'points_3_grade',
            'points_4_grade', 'boo', 'middle_school_id', 'profession_id'
        ];
    }

    protected function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'emso' => 'required|size:13',
            'matura_points' => 'present|numeric|min:0|max:34',
            'matura_done' => ['present', Rule::in(['D', 'N'])],
            'points_3_grade' => 'present|numeric|min:1|max:5',
            'points_4_grade' => 'present|numeric|min:1|max:5',
            'profession_id' => 'required|exists:professions,id',
            'middle_school_id' => 'required|exists:middle_schools,id'
        ];
    }
}
