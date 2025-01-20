<?php

declare(strict_types = 1);

namespace App\Attributes;

use Attribute;

#[Attribute]
class Put extends Route
{
    public function __construct(string $path)
    {
        parent::__construct($path, 'put');
    }
}
