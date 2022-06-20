<?php

namespace FluxRestApi\Adapter\Body;

use FluxRestApi\Adapter\Body\Type\BodyType;
use FluxRestApi\Adapter\Body\Type\DefaultBodyType;

class HtmlBodyDto implements BodyDto
{

    private function __construct(
        public readonly string $html
    ) {

    }


    public static function new(
        ?string $html = null
    ) : static {
        return new static(
            $html ?? ""
        );
    }


    public function getType() : BodyType
    {
        return DefaultBodyType::HTML;
    }
}
