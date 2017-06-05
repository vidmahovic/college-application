<?php

namespace CollegeApplication\Parsing;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

/**
 * Class ScoreParser
 *
 * @package \CollegeApplication\Parsing
 */
abstract class ScoreParser implements FileParser
{
    protected $errors = [];
    protected $lines = 0;

    public function parse(UploadedFile $file): Collection
    {
        $lines = collect();

        foreach (file($file) as $line) {
            $line_attrs = $this->parseLine($line);
            $validator = $this->getValidationFactory()->make($line_attrs, $this->rules());

            if($validator->fails())
                array_push($this->errors, $line_attrs);
            else
                $lines->push($line_attrs);

            $this->lines++;
        }

        return $lines;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getLines(): int
    {
        return $this->lines;
    }

    /**
     * @return \Illuminate\Contracts\Validation\Factory
     */
    private function getValidationFactory()
    {
        return app('validator');
    }


    protected abstract function parseLine(string $line): array;
    protected abstract function rules(): array;

}
