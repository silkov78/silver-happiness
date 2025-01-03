<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Router;

class RouterTest extends TestCase
{
    public function test_it_registers_a_route(): void
    {
        // given that we have a router object
        $router = new Router();

        // when we call a register method
        $router->register('get', '/users', ['UserController', 'index']);

        // then we assert route was registered
        $expected = [
            'get' => [
                '/users' => ['UserController', 'index'],
            ],
        ];

        $this->assertEquals($expected, $router->routes());
    }

    public function test_it_registers_a_post_route(): void
    {
        $router = new Router();
        $router->post('/users', ['UserController', 'store']);
        $expected = [
            'post' => [
                '/users' => ['UserController', 'store'],
            ],
        ];

        $this->assertEquals($expected, $router->routes());
    }

    public function test_it_registers_a_get_route(): void
    {
        $router = new Router();
        $router->get('/users', ['UserController', 'index']);

        $expected = [
            'get' => [
                '/users' => ['UserController', 'index'],
            ],
        ];

        $this->assertEquals($expected, $router->routes());
    }

    public function test_there_are_no_routes_when_router_is_created(): void
    {
        $router = new Router();

        $this->assertEmpty($router->routes());
    }
}
