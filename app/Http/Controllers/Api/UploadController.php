<?php

namespace App\Http\Controllers\Api;

use App\Models\MaturaScore;
use App\Transformers\ScoreErrorTransformer;
use App\Transformers\ScoreTransformer;
use CollegeApplication\Parsing\GeneralMaturaParser;
use CollegeApplication\Parsing\MaturaSubjectsParser;
use CollegeApplication\Parsing\ScoreParser;
use CollegeApplication\Parsing\VocationalMaturaParser;
use Dingo\Api\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Class ScoreUploadController
 *
 * @package \App\Http\Controllers\Api
 */
class UploadController extends ApiController
{

    public function generalMaturaScores()
    {
        if(! $this->request->user()->isEnrollmentService())
            throw new AuthorizationException('Unauthorized access');

        $file = $this->getValidatedFile('general_matura');

        $parser = new GeneralMaturaParser;
        $data = $parser->parse($file);

        ['new' => $new, 'updated' => $updated] = MaturaScore::storeScores($data->map(function($item, $key) {
            $item['general_matura'] = true;
            return $item;
        }));

        return $this->buildResponse($parser, $new, $updated);

    }

    // TODO: needs implementation.
    public function generalMaturaSubjectScores() {

        if(! $this->request->user()->isEnrollmentService())
            throw new AuthorizationException('Unauthorized access.');

        $file = $this->getValidatedFile('general_matura_subjects');

        $parser = new MaturaSubjectsParser;
        $data = $parser->parse($file);

        // Store data

        return $this->buildResponse($parser);

    }

    public function vocationalMaturaScores()
    {
        if(! $this->request->user()->isEnrollmentService())
            throw new AuthorizationException('Unauthorized access.');

        $file = $this->getValidatedFile('vocational_matura');

        $parser = new VocationalMaturaParser;
        $data = $parser->parse($file);

        ['new' => $new, 'updated' => $updated] = MaturaScore::storeScores($data->map(function($item, $key) {
            $item['general_matura'] = false;
            return $item;
        }));

        return $this->buildResponse($parser, $new, $updated);

    }

    // TODO: needs impelementation
    public function vocationalMaturaSubjectScores()
    {
        if(! $this->request->user()->isEnrollmentService())
            throw new AuthorizationException('Unauthorized access.');

        $file = $this->getValidatedFile('vocational_matura_subjects');

        $parser = new MaturaSubjectsParser;
        $data = $parser->parse($file);

        // Store data

        return $this->buildResponse($parser);

    }

    private function getValidatedFile(string $filename)
    {
        $this->validate($this->request, [$filename => 'required|file']);
        $file = $this->request->file($filename);

        if(! $file->isValid())
            throw new BadRequestHttpException($file->getErrorMessage());

        return $file;

    }

    public function buildResponse(ScoreParser $parser, $new, $updated)
    {
        $parse_result = new \stdClass;
        $parse_result->total = $parser->getLines();
        $parse_result->errors = $parser->getErrors();
        $parse_result->new = $new;
        $parse_result->updated = $updated;

        return $this->response->item($parse_result, new ScoreTransformer);
    }


}
