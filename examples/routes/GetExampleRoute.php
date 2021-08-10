<?php

namespace Fluxlabs\FluxRestApi\Route\Example;

use Fluxlabs\FluxRestApi\Body\JsonBodyDto;
use Fluxlabs\FluxRestApi\Request\RequestDto;
use Fluxlabs\FluxRestApi\Response\ResponseDto;
use Fluxlabs\FluxRestApi\Route\Route;

class GetExampleRoute implements Route
{

    public static function new() : /*static*/ self
    {
        $route = new static();

        return $route;
    }


    public function getRoute() : string
    {
        return "/example/get";
    }


    public function getMethod() : string
    {
        return "GET";
    }


    public function getBodyType() : ?string
    {
        return null;
    }


    public function handle(RequestDto $request) : ResponseDto
    {
        return ResponseDto::new(
            JsonBodyDto::new(
                [
                    "Some test data",
                    1234,
                    true
                ]
            )
        );
    }
}
