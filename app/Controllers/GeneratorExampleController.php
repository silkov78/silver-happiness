<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Attributes\Get;
use App\Attributes\Put;
use App\Attributes\Post;

class GeneratorExampleController
{
    public function __construct() {    
    }

    #[Get('/examples/generators')]
    public function index()
    {   
        $numbers = $this->lazyRange(1, 10);

        foreach ($numbers as $key => $number) {
            echo $key . ':' . $number . '<br/>';
        }
    }

    private function lazyRange(int $start, int $end): \Generator 
    {
        for ($i = $start; $i <= $end; $i++) {
            yield $i * 5 => $i;
        }
    }
}
