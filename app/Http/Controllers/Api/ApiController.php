<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
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

    protected function setFilters(Model $model)
    {
        if(property_exists($model, 'filters')) {

            $available_filters = $model::$filters;

            foreach($this->request->query() as $filter => $val) {
                if(strlen($val) > 0 && in_array($filter, $available_filters)) {
                    $model = $model->filter($filter, $val);
                }
            }
        }

        return $model;
    }

}
