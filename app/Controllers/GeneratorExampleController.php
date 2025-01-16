<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\View;
use App\Attributes\Route;

class GeneratorExampleController
{
    public function __construct() {    
    }

    #[Route('/examples/generators')]
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
