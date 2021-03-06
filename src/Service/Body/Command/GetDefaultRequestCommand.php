<?php

namespace FluxRestApi\Service\Body\Command;

use FluxRestApi\Adapter\Method\CustomMethod;
use FluxRestApi\Adapter\Server\ServerRawRequestDto;
use FluxRestApi\Adapter\ServerType\ServerType;

class GetDefaultRequestCommand
{

    private function __construct()
    {

    }


    public static function new() : static
    {
        return new static();
    }


    public function getDefaultRequest() : ServerRawRequestDto
    {
        $query_params = $_GET;

        $route = explode("&", $_SERVER["QUERY_STRING"])[0];
        unset($query_params[$route]);

        return ServerRawRequestDto::new(
            $route,
            explode("?", $_SERVER["REQUEST_URI"])[0],
            CustomMethod::factory(
                $_SERVER["REQUEST_METHOD"]
            ),
            str_contains($_SERVER["SERVER_SOFTWARE"], ServerType::NGINX->value) ? ServerType::NGINX : ServerType::APACHE,
            $query_params,
            file_get_contents("php://input") ?: null,
            $_POST,
            $_FILES,
            getallheaders(),
            $_COOKIE
        );
    }
}
