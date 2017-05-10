<?php

namespace App\Http\Controllers\Api;

use App\Models\Faculty;
use App\Models\FacultyProgram;
use App\Transformers\ApplicationTransformer;
use CollegeApplication\Search\ApplicationSearch\ApplicationSearch;
use Dingo\Api\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Class FacultyController
 *
 * @package \App\Http\Controllers\Api
 */
class FacultyController extends ApiController
{

    private $search;

    public function __construct(ApplicationSearch $search, \Dingo\Api\Http\Request $request)
    {
        $this->search = $search;
        parent::__construct($request);
    }

    public function applications($faculty_id)
    {
        $user = $this->request->user();

        // Restrict access to faculty referents only.
        if((! $user->isReferent()) && (! $user->isAdmin()))
            throw new UnauthorizedHttpException('Basic');

        $this->request['filters'] = ['faculty_id' => $faculty_id];

        $applications = $this->search
            ->applyFiltersFromRequest($this->request)
            ->filed()
            ->paginate($this->request->get('perPage') ?? 30);

        return $this->response->paginator($applications, new ApplicationTransformer);
    }
}
