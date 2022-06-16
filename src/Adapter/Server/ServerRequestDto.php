<?php

namespace FluxRestApi\Adapter\Server;

use FluxRestApi\Adapter\Body\BodyDto;
use FluxRestApi\Adapter\Header\HeaderKey;
use FluxRestApi\Adapter\Method\Method;
use FluxRestApi\Adapter\ServerType\ServerType;

class ServerRequestDto
{

    /**
     * @param string[] $query_params
     * @param string[] $headers
     * @param string[] $cookies
     * @param string[] $params
     */
    private function __construct(
        public readonly string $route,
        public readonly string $original_route,
        public readonly Method $method,
        public readonly ServerType $server_type,
        public readonly array $query_params,
        public readonly ?string $raw_body,
        public readonly array $headers,
        public readonly array $cookies,
        public readonly array $params,
        public readonly ?BodyDto $parsed_body
    ) {

    }


    /**
     * @param string[]|null $query_params
     * @param string[]|null $headers
     * @param string[]|null $cookies
     * @param string[]|null $params
     */
    public static function new(
        string $route,
        string $original_route,
        Method $method,
        ServerType $server_type,
        ?array $query_params = null,
        ?string $raw_body = null,
        ?array $headers = null,
        ?array $cookies = null,
        ?array $params = null,
        ?BodyDto $parsed_body = null
    ) : static {
        $headers ??= [];

        return new static(
            $route,
            $original_route,
            $method,
            $server_type,
            $query_params ?? [],
            $raw_body,
            array_combine(array_map("strtolower", array_keys($headers)), $headers),
            $cookies ?? [],
            $params ?? [],
            $parsed_body
        );
    }


    public function getCookie(string $name) : ?string
    {
        return $this->cookies[$name] ?? null;
    }


    public function getHeader(HeaderKey $key) : ?string
    {
        return $this->headers[strtolower($key->value)] ?? null;
    }


    public function getParam(string $name) : ?string
    {
        return $this->params[$name] ?? null;
    }


    public function getQueryParam(string $name) : ?string
    {
        return $this->query_params[$name] ?? null;
    }
}
