<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Container; 
use App\Services\PaymentGatewayInterface;
use App\Exceptions\Container\ContainerException;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{   
    private Container $container;
    private $payment;

    public function setUp(): void
    {
        $this->container = new Container();

        $this->payment = new class() implements PaymentGatewayInterface
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
        // when container->has(payment) was called
        $result = $this->container->has($this->payment::class);

        // then we assert has method returns false
        $this->assertFalse($result);
    }

    public function test_set_method_with_callable(): void
    {   
        // given container with empty entries and cotroller class
        // when container->set(payment)->charge was called
        $this->container->set(
            $this->payment::class,
            fn(Container $c) => $this->payment::class
        );

        $result = $this->container->has($this->payment::class);

        // then we assert result equal true
        $this->assertTrue($result);
    }

    public function test_set_method_with_string(): void
    {   
        // given container with empty entries and cotroller class
        // when container->set(payment)->charge was called
        $this->container->set(
            $this->payment::class,
            $this->payment::class
        );

        $result = $this->container->has($this->payment::class);

        // then we assert result equal true
        $this->assertTrue($result);
    }

    public function test_get_method_for_unset_entry(): void
    {   
        // given container with empty entries and cotroller class
        // when container->get(payment)->charge was called
        $result = $this->container->get($this->payment::class)->charge(['piotr'], 35, 2);

        // then we assert method will be executed
        $this->assertSame(true, $result);
    }

    public function test_get_method_for_set_entry(): void
    {   
        // given container with entries and cotroller class
        $this->container->set(
            $this->payment::class,
            fn(Container $c) => $this->payment
        );

        // when container->get(payment)->charge was called
        $result = $this->container->get($this->payment::class)->charge(['piotr'], 35, 2);

        // then we assert method will be executed
        $this->assertSame(true, $result);
    }

    public function test_get_method_for_interface_binding_which_was_set(): void
    {   
        // given container with entries and cotroller class
        $this->container->set(
            PaymentGatewayInterface::class,
            fn(Container $c) => $this->payment
        );

        // when container->get(payment)->charge was called
        $result = $this->container->get($this->payment::class)->charge(['piotr'], 25, 2);

        // then we assert method will be executed
        $this->assertSame(true, $result);
    }

    public function test_get_method_for_interface_binding_which_unset(): void
    {   
        $this->expectException(ContainerException::class);
        $result = $this->container->get(PaymentGatewayInterface::class)->charge(['piotr'], 25, 2);

        // then we assert method will be executed
        $this->assertSame(true, $result);
    }
}
