<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Container; 
use App\Services\PaymentGatewayInterface;
use PHPUnit\Framework\MockObject\MockClass;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{   
    private Container $container;
    private $controller;

    public function setUp(): void
    {
        $this->container = new Container();

        $this->controller = new class() implements PaymentGatewayInterface
        {
            public function charge(array $customer, float $amount, float $tax): bool
            {
                return true;
            }
        };
    }

    public function test_has_method_for_unset_entry(): void
    {   
        // given container with empty entries and cotroller class
        // when container->has(controller) was called
        $result = $this->container->has($this->controller::class);

        // then we assert has method returns false
        $this->assertFalse($result);
    }

    public function test_set_method_with_callable(): void
    {   
        // given container with empty entries and cotroller class
        // when container->set(controller)->charge was called
        $this->container->set(
            $this->controller::class,
            fn(Container $c) => $this->controller::class
        );

        $result = $this->container->has($this->controller::class);

        // then we assert result equal true
        $this->assertTrue($result);
    }

    public function test_set_method_with_string(): void
    {   
        // given container with empty entries and cotroller class
        // when container->set(controller)->charge was called
        $this->container->set(
            $this->controller::class,
            $this->controller::class
        );

        $result = $this->container->has($this->controller::class);

        // then we assert result equal true
        $this->assertTrue($result);
    }

    public function test_get_method_for_unset_entry(): void
    {   
        // given container with empty entries and cotroller class
        // when container->get(controller)->charge was called
        $result = $this->container->get($this->controller::class)->charge(['piotr'], 35, 2);

        // then we assert method will be executed
        $this->assertSame(true, $result);
    }

    public function test_get_method_for_set_entry(): void
    {   
        // given container with entries and cotroller class
        $this->container->set(
            $this->controller::class,
            fn(Container $c) => $this->controller
        );

        // when container->get(controller)->charge was called
        $result = $this->container->get($this->controller::class)->charge(['piotr'], 35, 2);

        // then we assert method will be executed
        $this->assertSame(true, $result);
    }

    public function test_get_method_for_interface_binding_which_was_set(): void
    {   
        // given container with entries and cotroller class
        $this->container->set(
            PaymentGatewayInterface::class,
            fn(Container $c) => $this->controller
        );

        // when container->get(controller)->charge was called
        $result = $this->container->get($this->controller::class)->charge(['piotr'], 25, 2);

        // then we assert method will be executed
        $this->assertSame(true, $result);
    }

    public function test_get_method_for_interface_binding_which_unset(): void
    {   
        // given container with entries and cotroller class
        $this->controller = new class() implements PaymentGatewayInterface
        {
            public function charge(array $customer, float $amount, float $tax): bool
            {
                return true;
            }
        };

        // when container->get(controller)->charge was called
        $result = $this->container->get($this->controller::class)->charge(['piotr'], 25, 2);

        // then we assert method will be executed
        $this->assertSame(true, $result);
    }
}
