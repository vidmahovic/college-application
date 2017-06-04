<?php

namespace App\Http\Controllers\Api;

use App\Transformers\ScoreErrorTransformer;
use App\Transformers\ScoreTransformer;
use CollegeApplication\Parsing\GeneralMaturaScoreParser;
use Dingo\Api\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
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

        $this->validate($this->request, ['general_matura' => 'file']);

        $file = $this->request->file('general_matura');
        if (!$file->isValid())
            throw new BadRequestHttpException($file->getErrorMessage());

        $parser = new GeneralMaturaScoreParser;
        $data = $parser->parse($file);
        // TODO: Store parsed $data to DB.

        $parse_result = new \stdClass;
        $parse_result->total = $parser->getAllLines();
        $parse_result->new = $parser->getNewLines();
        $parse_result->updated =  $parser->getEditedLines();
        $parse_result->errors = $parser->getErrors();

        return $this->response->item($parse_result, new ScoreTransformer);

    }

    public function generalMaturaSubjectScores() {


        $file = $this->request->file('general-matura-subjects');
    }

    public function vocationalMaturaScores()
    {

    }

    public function vocationalMaturaSubjectScores()
    {

    }
}
