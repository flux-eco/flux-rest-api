<?php

namespace FluxRestApi\Adapter\Body;

use FluxRestApi\Adapter\Body\Type\BodyType;
use FluxRestApi\Adapter\Body\Type\DefaultBodyType;

class JsonBodyDto implements BodyDto
{

    private function __construct(
        public readonly mixed $data
    ) {

    }


    public static function new(
        mixed $data
    ) : static {
        return new static(
            $data
        );
    }


    public function getType() : BodyType
    {
        return DefaultBodyType::JSON;
    }
}
