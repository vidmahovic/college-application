<?php

namespace CollegeApplication\Parsing;
use App\Models\MaturaScore;
use App\Models\Subject;
use Illuminate\Validation\Rule;

/**
 * Class VocationalSubjectPArser
 *
 * @package \CollegeApplication\Parsing
 */
class VocationalSubjectParser extends MaturaFileParser
{

    public function setError(array $line)
    {
        $score = MaturaScore::where('emso', $line['emso'])->firstOrFail();
        $line['first_name'] = $score->first_name;
        $line['last_name'] = $score->last_name;
        parent::setError($line);
    }

    protected function rules(): array
    {
        return [
            'emso' => 'required|size:13',
            'subject_id' => 'required|exists:subjects,id',
            'matura_mark' => 'required|numeric|min:1|max:5',
            'matura_done' => ['required', Rule::in(['D', 'N'])],
            'third_grade_mark' => 'required|numeric|min:2|max:5',
            'fourth_grade_mark' => 'required|numeric|min:2|max:5',
            'status' => 'required|numeric|min:1|max:6'
        ];
    }

    protected function storeLine(array $line)
    {
        $score = MaturaScore::where('emso', $line['emso'])->first();

        if($score !== null) {
            $score->subjects()->attach($line['subject_id'], [
                'matura_mark' => $line['matura_mark'],
                'third_grade_mark' => $line['third_grade_mark'] == null ? null : $line['third_grade_mark'],
                'fourth_grade_mark' => $line['third_grade_mark'] == null ? null : $line['fourth_grade_mark']
            ]);
            $this->created_lines++;
        }
    }

    protected function parseLine(string $line): array
    {
        return array_combine($this->columns(), array_map('trim', explode('Q', $line)));
    }
    private function columns()
    {
        return [
            'emso', 'subject_id', 'matura_mark', 'third_grade_mark', 'fourth_grade_mark', 'matura_done', 'status'
        ];
    }
}
