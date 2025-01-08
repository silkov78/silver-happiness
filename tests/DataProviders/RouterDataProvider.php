<?php

namespace Tests\DataProviders;

class RouterDataProvider
{
    public function routeNotFoundCases(): array
    {
        return [
            ['/users', 'put'],
            ['/users', 'post'],
            ['/invoices', 'get'],
            ['/users', 'get'],
        ];
    }
}
