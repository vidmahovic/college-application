<?php

namespace CollegeApplication\Parsing;
use Illuminate\Http\UploadedFile;

/**
 * Class MaturaFileParser
 *
 * @package \CollegeApplication\Parsing
 */
abstract class MaturaFileParser
{
    protected $all_lines = 0;
    protected $created_lines = 0;
    protected $updated_lines = 0;
    protected $errors = [];

    public function parse(string $file_content): array
    {
        foreach(explode(PHP_EOL, $file_content) as $row) {
            $row = str_replace(['\r', '\t'], '', $row);
            $line = $this->parseLine($row);
            $validator = $this->getValidationFactory()->make($line, $this->rules());

            if($validator->fails()) {
                $this->setError($line);
            } else {

                $this->storeLine($line);

            }

            $this->all_lines++;

        }

        return [
            'all' => $this->getLines(),
            'new' => $this->getCreated(),
            'updated' => $this->getUpdated()
        ];
    }

    public function setError(array $line)
    {
        if(! array_has($line, ['emso', 'first_name', 'last_name']))
            throw new \Exception("EMSO, first name and last name must be included when setting error.");
        array_push($this->errors, array_only($line, ['emso', 'first_name', 'last_name']));
    }

    public function getLines()
    {
        return $this->all_lines;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getCreated()
    {
        return $this->created_lines;
    }

    public function getUpdated()
    {
        return $this->updated_lines;
    }

    /**
     * @return \Illuminate\Contracts\Validation\Factory
     */
    private function getValidationFactory()
    {
        return app('validator');
    }

    abstract protected function rules(): array;
    abstract protected function storeLine(array $line);
    abstract protected function parseLine(string $line): array;
}
