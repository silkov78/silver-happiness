<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Container; 
use App\Services\PaymentGatewayInterface;
use App\Exceptions\Container\ContainerException;
use PHPUnit\Framework\TestCase;

abstract class AbstractExampleClass {}

class ContainerTest extends TestCase
{   
    private Container $container;
    private $anonClass;

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

    public function test_throw_container_exception_because_of_abstract_class(): void
    {   
        $this->expectException(ContainerException::class);
        $this->container->get(AbstractExampleClass::class);
    }

}
