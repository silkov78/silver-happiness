<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Container; 
use PHPUnit\Framework\MockObject\MockClass;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{   
    private Container $container;
    private $anonClass;

    public function setUp(): void
    {
        $this->container = new Container();

        $this->anonClass = new class() {
            public function process()
            {
                return 'Hello!';
            }
        };
    }

}
