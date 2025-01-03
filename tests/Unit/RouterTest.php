<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Router;

class RouterTest extends TestCase
{
    private Router $router;

    protected function setUp(): void
    {
        $this->router = new Router();
    }

    public function test_there_are_no_routes_when_router_is_created(): void
    {
        $router = new Router();

        $this->assertEmpty($router->routes());
    }
    
    public function test_it_registers_a_route(): void
    {
        $this->router->register('get', '/users', ['UserController', 'index']);

        $expected = [
            'get' => [
                '/users' => ['UserController', 'index'],
            ],
        ];

        $this->assertEquals($expected, $this->router->routes());
    }

    public function test_it_registers_a_post_route(): void
    {
        $this->router->post('/users', ['UserController', 'store']);
        $expected = [
            'post' => [
                '/users' => ['UserController', 'store'],
            ],
        ];

        $this->assertEquals($expected, $this->router->routes());
    }

    public function test_it_registers_a_get_route(): void
    {
        $this->router->get('/users', ['UserController', 'index']);

        $expected = [
            'get' => [
                '/users' => ['UserController', 'index'],
            ],
        ];

        $this->assertEquals($expected, $this->router->routes());
    }

}
