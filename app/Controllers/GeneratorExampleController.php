<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\View;

class GeneratorExampleController
{
    public function __construct() {    
    }

    public function index()
    {   
        $numbers = $this->lazyRange(1, 300000);

        foreach ($numbers as $key => $number) {
            echo $key . ':' . $number . '<br/>';
        }
    }

    private function lazyRange(int $start, int $end): \Generator 
    {
        for ($i = $start; $i <= $end; $i++) {
            yield $i;
        }
    }
}
