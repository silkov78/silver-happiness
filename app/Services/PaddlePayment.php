<?php

declare(strict_types = 1);

namespace App\Services;

class PaddlePayment implements PaymentGatewayInterface
{
    public function charge(array $customer, float $amount, float $tax): bool
    {
        sleep(1);

        echo 'Paddle payment was processed.</br>';

        return (bool) mt_rand(0, 1);
    }
}