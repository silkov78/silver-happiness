<?php

namespace Tests\DataProviders;

use App\Container;

interface AnonInterface {}

class ContainerDataProvider
{   
    private $anonClass;

    public function __construct()
    {
        $this->anonClass = new class() implements AnonInterface
        {
            public function anonClassInvitation()
            {
                return 'I am anonClass!';
            }
        };
    }

    public function bindingBySetMethodCases(): array
    {   
        $anonClass = $this->anonClass;

        return [
            [$anonClass::class, fn(Container $c) => new $anonClass()],
            [$anonClass::class, $anonClass::class],
            [AnonInterface::class, $anonClass::class]
        ];
    }
}
