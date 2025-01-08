<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Router;

use App\Exceptions\RouteNotFoundException;
use PHPUnit\Framework\TestCase;

    /**
     * ToDo
     * 1. - test_there_are_no_routes_when_router_is_created
     *    - create setUp with Router initiazlization
     * 2. test_it_registers_a_route 
     * 3. test_it_registers_a_post_route 
     * 4. test_it_registers_a_get_route 
     * 5. test_it_throws_route_not_found_exception 
     * 6. test_it_resolves_route_from_a_closure 
     *
     */

class RouterTest extends TestCase
{
    private Router $router;
    
    public function setUp(): void
    {
        $this->router = new Router();
    }

    public function test_there_are_no_routes_when_router_is_created(): void
    {
        // given object of Router $router
        // when routes doesn't registered
        $this->router = new Router();

        // then $router->routes should return empty array
        $this->assertEmpty($this->router->routes());
    }
}