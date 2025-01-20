<?php

declare(strict_types = 1);

namespace App\Attributes;

use Attribute;
use App\Contracts\RouteInterface;

#[Attribute]
class Route implements RouteInterface
{
    public function __construct(
        public string $path, public string $method = 'get'
    ) {
    }
}
