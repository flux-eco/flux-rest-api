<?php

namespace FluxRestApi\Adapter\Authorization\Schema;

use JsonSerializable;
use LogicException;

class CustomAuthorizationSchema implements AuthorizationSchema, JsonSerializable
{

    private string $_value;


    private function __construct(
        /*public readonly*/ string $value
    ) {
        $this->_value = $value;
    }


    public static function factory(string $value) : AuthorizationSchema
    {
        if (PHP_VERSION_ID >= 80100) {
            $schema = DefaultAuthorizationSchema::tryFrom($value);
        } else {
            $schema = LegacyDefaultAuthorizationSchema::tryFrom($value);
        }

        return $schema ?? static::new(
                $value
            );
    }


    private static function new(
        string $value
    ) : /*static*/ self
    {
        return new static(
            $value
        );
    }


    public function __debugInfo() : ?array
    {
        return [
            "value" => $this->value
        ];
    }


    public final function __get(string $key) : string
    {
        switch ($key) {
            case "value":
                return $this->_value;

            default:
                throw new LogicException("Can't get " . $key);
        }
    }


    public final function __set(string $key, /*mixed*/ $value) : void
    {
        throw new LogicException("Can't set");
    }


    public function jsonSerialize() : string
    {
        return $this->value;
    }
}