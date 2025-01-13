<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Container;

use App\Exceptions\Container\ContainerException;


// Examples
class WithoutConstructorClass {}

class WithEmptyConstructorClass {
    public function __construct() {}
}


class ContainerTest extends TestCase
{   
    private Container $container;

    public function setUp(): void
    {
        $this->container = new Container();
    }


    public function test_has_method(): void
    {   
        $anonClass = new class() {};

        $this->container->set(
            $anonClass::class,
            fn(Container $c) => new $anonClass()
        );

        $results = [
            $this->container->has($anonClass::class),
            $this->container->has('blablabla')
        ];

        $this->assertSame([true, false], $results);
    }

    /**
     * @dataProvider Tests\DataProviders\ContainerDataProvider::bindingBySetMethodCases
     */
    public function test_binding_using_set_method($id, $concrete): void
    {   
        $this->assertSame(
            'I am anonClass!',
            $this->container->get($id)->anonClassInvitation()
        );
    }

    public function test_autowiring_with_class_without_constructor(): void
    {   
        $withoutConstructorClass = $this->container->get(WithoutConstructorClass::class);

        $this->assertSame(
            'Tests\Unit\WithoutConstructorClass',
            $withoutConstructorClass::class
        );
    }

    public function test_autowiring_with_empty_constructor(): void
    {   
        $withoutConstructorClass = $this->container->get(WithEmptyConstructorClass::class);

        $this->assertSame(
            'Tests\Unit\WithEmptyConstructorClass',
            $withoutConstructorClass::class
        );
    }

    /**
     * @dataProvider Tests\DataProviders\ContainerDataProvider::throwContainerExceptionCases
     */
    public function test_throw_container_exception($className): void
    {   
        $this->expectException(ContainerException::class);
        $this->container->get($className);
    }
}
