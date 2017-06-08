<?php

namespace CollegeApplication\Parsing;
use App\Models\MaturaScore;
use Illuminate\Validation\Rule;

/**
 * Class GeneralSubjectParser
 *
 * @package \CollegeApplication\Parsing
 */
class GeneralSubjectParser extends MaturaFileParser
{

    public function setError(array $line)
    {
        $score = MaturaScore::where('emso', $line['emso'])->firstOrFail();
        $line['first_name'] = $score->first_name;
        $line['last_name'] = $score->last_name;
        return parent::setError($line);
    }

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
            'matura_done' => ['required', Rule::in(['D', 'N'])],
            'third_grade_mark' => 'required_with:fourth_grade_mark|numeric|min:2|max:5',
            'fourth_grade_mark' => 'required_with:third_grade_mark|numeric|min:2|max:5',
            'status' => 'required|numeric|min:0|max:7'
        ];
    }

    protected function storeLine(array $line)
    {
        $score = MaturaScore::where('emso', $line['emso'])->first();
        if($score !== null) {
            $score->subjects()->attach($line['subject_id'], [
                'matura_mark' => $line['matura_mark'] == null ? null : $line['matura_mark'],
                'third_grade_mark' => $line['third_grade_mark'] == null ? null : $line['third_grade_mark'],
                'fourth_grade_mark' => $line['third_grade_mark'] == null ? null : $line['fourth_grade_mark']
            ]);
            $this->created_lines++;
        }

    }

    private function columns()
    {
        return [
            'emso', 'subject_id', 'matura_mark', 'third_grade_mark', 'fourth_grade_mark', 'matura_done', 'status'
        ];
    }

}
