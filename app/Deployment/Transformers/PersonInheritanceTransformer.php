<?php

namespace App\Deployment\Transformers;

use Grimm\PersonInheritance;
use League\Fractal\TransformerAbstract;

class PersonInheritanceTransformer extends TransformerAbstract
{

    public function transform(PersonInheritance $item)
    {
        return [
            'entry' => $item->entry,
        ];
    }
}
