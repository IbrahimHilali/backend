<?php

namespace App\Deployment\Transformers;

use Grimm\PersonInformation;
use League\Fractal\TransformerAbstract;

class PersonInformationTransformer extends TransformerAbstract
{

    public function transform(PersonInformation $item)
    {
        return [
            'data' => $item->data,
            'code' => $item->code->name,
            'error_generated' => $item->code->error_generated,
        ];
    }
}
