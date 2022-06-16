<?php

namespace FluxRestApi\Adapter\Server;

use FluxRestApi\Adapter\Header\HeaderKey;
use FluxRestApi\Adapter\Method\Method;
use FluxRestApi\Adapter\ServerType\ServerType;

class ServerRawRequestDto
{

    /**
     * @param string[] $query_params
     * @param string[] $headers
     * @param string[] $cookies
     */
    private function __construct(
        public readonly string $route,
        public readonly string $original_route,
        public readonly Method $method,
        public readonly ServerType $server_type,
        public readonly array $query_params,
        public readonly ?string $body,
        public readonly array $post,
        public readonly array $files,
        public readonly array $headers,
        public readonly array $cookies
    ) {

    }


    /**
     * @param string[]|null $query_params
     * @param string[]|null $headers
     * @param string[]|null $cookies
     */
    public static function new(
        string $route,
        string $original_route,
        Method $method,
        ServerType $server_type,
        ?array $query_params = null,
        ?string $body = null,
        ?array $post = null,
        ?array $files = null,
        ?array $headers = null,
        ?array $cookies = null
    ) : static {
        $headers ??= [];

        return new static(
            $route,
            $original_route,
            $method,
            $server_type,
            $query_params ?? [],
            $body,
            $post ?? [],
            $files ?? [],
            array_combine(array_map("strtolower", array_keys($headers)), $headers),
            $cookies ?? []
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


    public function getQueryParam(string $name) : ?string
    {
        return $this->query_params[$name] ?? null;
    }
}
