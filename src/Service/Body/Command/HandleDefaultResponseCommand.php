<?php

namespace FluxRestApi\Service\Body\Command;

use FluxRestApi\Adapter\Header\DefaultHeaderKey;
use FluxRestApi\Adapter\Server\ServerRawResponseDto;
use FluxRestApi\Adapter\ServerType\ServerType;
use LogicException;

class HandleDefaultResponseCommand
{

    private function __construct()
    {

    }


    public static function new() : static
    {
        return new static();
    }


    public function handleDefaultResponse(ServerRawResponseDto $response, ServerType $server_type) : void
    {
        if (headers_sent($filename, $line)) {
            throw new LogicException("Do not manually output headers or body in " . $filename . ":" . $line);
        }

        http_response_code($response->status->value);

        $headers = $response->headers;

        if ($response->sendfile !== null) {
            if ($server_type === ServerType::NGINX) {
                $headers[DefaultHeaderKey::X_ACCEL_REDIRECT->value] = $response->sendfile;
            } else {
                $headers[DefaultHeaderKey::X_SENDFILE->value] = $response->sendfile;
            }
            $headers[DefaultHeaderKey::CONTENT_TYPE->value] = "";
        }

        foreach ($headers as $key => $value) {
            header($key . ":" . $value);
        }

        foreach ($response->cookies as $cookie) {
            if ($cookie->value !== null) {
                setcookie(
                    $cookie->name,
                    $cookie->value,
                    $cookie->expires_in !== null ? (time() + $cookie->expires_in) : 0,
                    $cookie->path,
                    $cookie->domain,
                    $cookie->secure,
                    $cookie->http_only
                );
            } else {
                setcookie(
                    $cookie->name,
                    "",
                    0,
                    $cookie->path,
                    $cookie->domain
                );
            }
        }

        if ($response->body !== null) {
            echo $response->body;
        }
    }
}
