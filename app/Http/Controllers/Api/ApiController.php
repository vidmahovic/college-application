<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ApiController
 *
 * @package \\${NAMESPACE}
 */
class ApiController extends Controller
{
    use Helpers;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validateRequest(array $rules) {
        return app('validator')->make($this->request->all(), $rules);
    }


    protected function setSorting($model)
    {
        if($this->wantsSorting()) {
            $model = $model->orderBy($this->request->get('by'), $this->request->get('order') ?? 'asc');
        }
        return $model;
    }

    protected function setLimit($model) {
        if($this->wantsLimit()) {
            $model = $model->take((int) $this->request->get('limit'));
        }
        return $model;
    }

    protected function wantsSorting() {
        return $this->request->has('by');
    }

    protected function wantsLimit() {
        return $this->request->has('limit') && (int) $this->request->get('limit') > 0;
    }

}
