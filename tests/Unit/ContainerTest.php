<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Container; 
use App\Services\PaymentGatewayInterface;
use App\Exceptions\Container\ContainerException;
use PHPUnit\Framework\TestCase;


// Example Classes
abstract class AbstractExampleClass {}

class WithoutConstructorClass {}

class WithEmptyConstructorClass {
    public function __construct() {}
}

class ConstructorWithoutTypeHintClass {
    public function __construct(private $param) {}
}

class ConstructorWithReflectionUnionTypeClass {
    public function __construct(private \ReflectionUnionType $param) {}
}

class ConstructorWithReflectionIntersectionTypeClass {
    public function __construct(private \ReflectionUnionType $param) {}
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
        $this->container->set($id, $concrete);

        $result = $this->container->get($id)->anonClassInvitation();

        $this->assertSame('I am anonClass!', $result);
    }

    public function test_autowiring_with_class_without_constructor(): void
    {   
        $withoutConstructorClass = $this->container->get(WithoutConstructorClass::class);

        $result = $withoutConstructorClass::class;
        $expected = 'Tests\Unit\WithoutConstructorClass';

        $this->assertSame($expected, $result);
    }

    public function test_autowiring_with_empty_constructor(): void
    {   
        $withoutConstructorClass = $this->container->get(WithEmptyConstructorClass::class);

        $expected = 'Tests\Unit\WithEmptyConstructorClass';
        $result = $withoutConstructorClass::class;

        $this->assertSame($expected, $result);
    }

    public function test_throw_container_exception_because_of_uninstantiable_class(): void
    {   
        $this->expectException(ContainerException::class);
        $this->container->get(AbstractExampleClass::class);
    }

    public function test_throw_container_exception_because_constructor_does_not_have_typehints(): void
    {   
        $this->expectException(ContainerException::class);
        $this->container->get(ConstructorWithoutTypeHintClass::class);
    }

    public function test_throw_container_exception_because_constructor_has_ReflectionUnionType(): void
    {   
        $this->expectException(ContainerException::class);
        $this->container->get(ConstructorWithReflectionUnionTypeClass::class);
    }

    public function test_throw_container_exception_because_constructor_has_ReflectionIntersectionType(): void
    {   
        $this->expectException(ContainerException::class);
        $this->container->get(ConstructorWithReflectionIntersectionTypeClass::class);
    }

}
