<?php

namespace FluxRestApi\Adapter\Body;

use FluxRestApi\Adapter\Body\Type\BodyType;
use FluxRestApi\Adapter\Body\Type\LegacyDefaultBodyType;

class FormDataBodyDto implements BodyDto
{

    private array $data;
    private array $files;


    private function __construct(
        /*public readonly*/ array $data,
        /*public readonly*/ array $files
    ) {
        $this->data = $data;
        $this->files = $files;
    }


    public static function new(
        ?array $data = null,
        ?array $files = null
    ) : /*static*/ self
    {
        return new static(
            $data ?? [],
            $files ?? []
        );
    }


    public function getData() : array
    {
        return $this->data;
    }


    public function getFiles() : array
    {
        return $this->files;
    }


    public function getType() : BodyType
    {
        return LegacyDefaultBodyType::FORM_DATA();
    }
}