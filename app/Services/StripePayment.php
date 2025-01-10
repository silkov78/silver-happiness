<?php

declare(strict_types = 1);

namespace App\Services;

class StripePayment implements PaymentGatewayServiceInterface
{
    public function charge(array $customer, float $amount, float $tax): bool
    {
        sleep(1);

        echo 'Stripe payment was processed.</br>';

        return (bool) mt_rand(0, 1);
    }
}