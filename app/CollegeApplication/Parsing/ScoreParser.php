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
    protected $new = 0;
    protected $edited = 0;


    public function parse(UploadedFile $file): Collection
    {
        $lines = collect();

        foreach (file($file) as $line) {
            $line_attrs = $this->parseLine($line);
            $validator = $this->getValidationFactory()->make($line_attrs, $this->rules());

            if($validator->fails()) {
                array_push($this->errors, $line_attrs);
            }

            $this->new += 1;
            $this->lines += 1;

            $lines->push($line_attrs);
        }

        return $lines;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getAllLines(): int
    {
        return $this->lines;
    }

    public function getNewLines(): int
    {
        return $this->new;
    }

    public function getEditedLines(): int
    {
        return $this->edited;
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
