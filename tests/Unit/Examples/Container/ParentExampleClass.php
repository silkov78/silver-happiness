<?php

namespace Tests\Unit\Examples\Container;

class ExampleClass
{
    public function __construct(protected ChildExampleClass $childExample)
    {
    }

    public function process()
    {
        return 'I am parent class!';
    }
}