<?php

namespace App\Deployment;

use League\Fractal\Serializer\ArraySerializer;

class PlainArraySerializer extends ArraySerializer
{
    public function collection($resourceKey, array $data)
    {
        return $data;
    }
}
