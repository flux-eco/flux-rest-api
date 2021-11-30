<?php

namespace FluxRestApi\Server;

use FluxLegacyEnum\Adapter\Backed\LegacyStringBackedEnum;

/**
 * @method static static APACHE() apache
 * @method static static NGINX() nginx
 * @method static static SWOOLE() swoole
 */
class LegacyDefaultServer extends LegacyStringBackedEnum implements Server
{

}
