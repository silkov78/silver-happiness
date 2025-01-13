<?php

namespace Tests\DataProviders;

use App\Container;


// Example Classes
interface AnonInterface {}

class WithoutConstructorClass {}

class WithEmptyConstructorClass {
    public function __construct() {}
}

abstract class AbstractExampleClass {}

class ConstructorWithoutTypeHintClass {
    public function __construct(private $param) {}
}

class ConstructorWithBuiltinClass {
    public function __construct(private string $param) {}
}

class ConstructorWithUnionTypeClass {
    public function __construct(
        private WithoutConstructorClass|WithEmptyConstructorClass $param
    ) {}
}


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

    public function throwContainerExceptionCases(): array
    {   
        return [
            [AbstractExampleClass::class],
            [ConstructorWithoutTypeHintClass::class],
            [ConstructorWithBuiltinClass::class],
            [ConstructorWithUnionTypeClass::class],
        ];
    }
}
