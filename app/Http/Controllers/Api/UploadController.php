<?php

namespace App\Http\Controllers\Api;

use App\Models\MaturaScore;
use App\Transformers\ScoreTransformer;
use CollegeApplication\Parsing\GeneralScoreParser;
use CollegeApplication\Parsing\GeneralSubjectParser;
use CollegeApplication\Parsing\VocationalScoreParser;
use CollegeApplication\Parsing\VocationalSubjectParser;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ScoreUploadController
 *
 * @package \App\Http\Controllers\Api
 */
class UploadController extends ApiController
{

    public function storeGeneralMatura()
    {
        if (!$this->request->user()->isEnrollmentService())
            throw new AuthorizationException('Unauthorized access');

        $score_parser = new GeneralScoreParser;
        $subject_parser = new GeneralSubjectParser;

        // Delete old general matura records.
        foreach (MaturaScore::where('general_matura', true)->get() as $score) {
            $score->subjects()->detach();
            $score->delete();
        }

        $response = new \stdClass;

        $response->candidates = $score_parser->parse($this->getValidatedFile('general_matura'));
        $response->subjects = $subject_parser->parse($this->getValidatedFile('general_matura_subjects'));
        $response->errors = array_merge($score_parser->getErrors(), $subject_parser->getErrors());

        return $this->response->item($response, new ScoreTransformer);

    }

    public function storeVocationalMatura()
    {
        if (!$this->request->user()->isEnrollmentService())
            throw new AuthorizationException('Unauthorized access');

        $score_parser = new VocationalScoreParser;
        $subject_parser = new VocationalSubjectParser;

        foreach (MaturaScore::where('general_matura', false)->get() as $score) {
            $score->subjects()->detach();
            $score->delete();
        }

        $response = new \stdClass;

        $response->candidates = $score_parser->parse($this->getValidatedFile('vocational_matura'));
        $response->subjects = $subject_parser->parse($this->getValidatedFile('vocational_matura_subjects'));
        $response->errors = array_merge($score_parser->getErrors(), $subject_parser->getErrors());

        return $this->response->item($response, new ScoreTransformer);

    }

    private function getValidatedFile(string $filename)
    {
        $this->validate($this->request, [$filename => 'required|string']);
        $file = base64_decode($this->request->get($filename));

//        if (!$file->isValid())
//            throw new BadRequestHttpException($file->getErrorMessage());

        return $file;

    }

}
