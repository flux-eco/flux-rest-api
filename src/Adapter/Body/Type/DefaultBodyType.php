<?php

namespace FluxRestApi\Adapter\Body\Type;

enum DefaultBodyType: string implements BodyType
{

    case FORM_DATA = "multipart/form-data";
    case HTML = "text/html";
    case JSON = "application/json";
    case TEXT = "text/plain";
}