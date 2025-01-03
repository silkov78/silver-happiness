<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Router;

use App\Exceptions\RouteNotFoundException;

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

    /**
    * @test
    * @dataProvider \Tests\DataProviders\RouterDataProvider::routeNotFoundCases
    */
    public function test_it_throws_route_not_found_exception(
        string $requestUri,
        string $requestMethod
    ): void
    {
        $users = new class() {
            public function delete()
            {
                return true;
            }
        };

        $this->router->post('/users', [$users::class, 'storage']);
        $this->router->get('/users', [$users::class, 'index']);

        $this->expectException(RouteNotFoundException::class);
        $this->router->resolve($requestUri, $requestMethod);
    }

    public function test_it_resolves_route_from_a_closure(): void
    {
        $this->router->get('/users', fn() => [1, 2 ,3]);

        $this->assertEquals(
            [1, 2, 3],
            $this->router->resolve('/users', 'get')
        );
    }

    public function test_it_resolves_route(): void
    {
        $users = new class() {
            public function index(): array
            {
                return [1, 2, 3];
            }
        };

        $this->router->get('/users', [$users::class, 'index']);

        $this->assertEquals(
            [1, 2, 3],
            $this->router->resolve('/users', 'get')
        );
    }

}
