<?php

namespace App\Transformers;

use Illuminate\Support\Collection;
use League\Fractal;
/**
 * Class AcceptedApplicationsTransformer
 *
 * @package \App\Transformers
 */
class AcceptedApplicationsTransformer extends Fractal\TransformerAbstract
{

    protected $defaultIncludes = ['eu', 'other'];

    public function transform($item)
    {
        return [];
    }

    public function includeEu($item)
    {
        return $this->collection($item->fromEu, new ApplicationTransformer);
    }

    public function includeOther($item)
    {
        return $this->collection($item->fromOther, new ApplicationTransformer);
    }
}

