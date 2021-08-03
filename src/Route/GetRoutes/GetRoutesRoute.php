<?php

namespace Fluxlabs\FluxRestApi\Route\GetRoutes;

use Fluxlabs\FluxRestApi\Body\Json\JsonBodyDto;
use Fluxlabs\FluxRestApi\Request\RequestDto;
use Fluxlabs\FluxRestApi\Response\ResponseDto;
use Fluxlabs\FluxRestApi\Route\Route;

class GetRoutesRoute implements Route
{

    private $get_routes;


    public static function new(callable $get_routes) : /*static*/ self
    {
        $route = new static();

        $route->get_routes = $get_routes;

        return $route;
    }


    public function getBodyClass() : ?string
    {
        return null;
    }


    public function getMethod() : ?string
    {
        return "GET";
    }


    public function getRoute() : string
    {
        return "/routes";
    }


    public function handle(RequestDto $request) : ResponseDto
    {
        return ResponseDto::new(
            JsonBodyDto::new(
                ($this->get_routes)()
            )
        );
    }
}
