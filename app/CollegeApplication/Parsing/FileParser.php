<?php
namespace CollegeApplication\Parsing;
use Illuminate\Http\UploadedFile;

/**
 * Class FileParser
 *
 * @package \\${NAMESPACE}
 */
interface FileParser
{
    public function parse(UploadedFile $file);
}
