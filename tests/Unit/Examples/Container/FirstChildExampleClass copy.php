<?php

namespace Tests\Unit\Examples\Container;

class SecondChildExampleClass
{
    public function __construct(protected int $intValue)
    {
    }

    public function process()
    {
        return 'I am parent class!';
    }
}