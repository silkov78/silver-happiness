<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Container; 
use PHPUnit\Framework\MockObject\MockClass;
use PHPUnit\Framework\TestCase;

interface AnonInterface {}

class ContainerTest extends TestCase
{   
    private Container $container;
    private $anonClass;

    public function setUp(): void
    {
        $this->container = new Container();

        $this->anonClass = new class() implements AnonInterface
        {
            public function process()
            {
                return 'Hello!';
            }
        };
    }

    public function test_binding_by_set_method_with_callable()
    {   
        $anonClass = $this->anonClass;

        $this->container->set(
            $anonClass::class,
            fn(Container $c) => new $anonClass()
        );

        $result = $this->container->get($anonClass::class)->process();

        $this->assertSame('Hello!', $result);
    }

    public function test_binding_by_set_method_with_string_class_name()
    {   
        $anonClass = $this->anonClass;

        $this->container->set(
            $anonClass::class, $anonClass::class,
        );

        $result = $this->container->get($anonClass::class)->process();

        $this->assertSame('Hello!', $result);
    }
    
    public function test_has_method()
    {   
        $anonClass = $this->anonClass;

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
}
