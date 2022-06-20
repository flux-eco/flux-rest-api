<?php

namespace FluxRestApi\Adapter\Authorization\ParseHttpBasic;

use FluxRestApi\Adapter\Authorization\ParseHttp\HttpAuthorizationDto;
use FluxRestApi\Adapter\Authorization\ParseHttp\ParseHttpAuthorization;
use FluxRestApi\Adapter\Authorization\Schema\DefaultAuthorizationSchema;
use FluxRestApi\Adapter\Body\TextBodyDto;
use FluxRestApi\Adapter\Server\ServerRawRequestDto;
use FluxRestApi\Adapter\Server\ServerResponseDto;
use FluxRestApi\Adapter\Status\DefaultStatus;

trait ParseHttpBasicAuthorization
{

    use ParseHttpAuthorization;

    private function parseHttpBasicAuthorization(ServerRawRequestDto $request) : HttpBasicAuthorizationDto|ServerResponseDto
    {
        $authorization = $this->parseHttpAuthorization(
            $request,
            HttpAuthorizationDto::new(
                DefaultAuthorizationSchema::BASIC
            )
        );
        if ($authorization instanceof ServerResponseDto) {
            return $authorization;
        }

        if ($authorization->schema !== DefaultAuthorizationSchema::BASIC) {
            return ServerResponseDto::new(
                TextBodyDto::new(
                    DefaultAuthorizationSchema::BASIC->value . " authorization schema needed"
                ),
                DefaultStatus::_400
            );
        }

        $authorization = base64_decode($authorization->parameters);

        if ($authorization === false) {
            return ServerResponseDto::new(
                TextBodyDto::new(
                    "Invalid " . DefaultAuthorizationSchema::BASIC->value . " authorization"
                ),
                DefaultStatus::_400
            );
        }

        if (empty($authorization) || !str_contains($authorization, ParseHttpBasicAuthorization_::SPLIT_USER_PASSWORD)) {
            return ServerResponseDto::new(
                TextBodyDto::new(
                    "Missing authorization user or password"
                ),
                DefaultStatus::_400
            );
        }

        $password = explode(ParseHttpBasicAuthorization_::SPLIT_USER_PASSWORD, $authorization);
        $user = array_shift($password);
        $password = implode(ParseHttpBasicAuthorization_::SPLIT_USER_PASSWORD, $password);

        if (empty($user) || empty($password)) {
            return ServerResponseDto::new(
                TextBodyDto::new(
                    "Missing authorization user or password"
                ),
                DefaultStatus::_400
            );
        }

        return HttpBasicAuthorizationDto::new(
            $user,
            $password
        );
    }
}
