<?php

declare(strict_types=1);

namespace App;

use Psr\Container\ContainerInterface;

use App\Exceptions\Container\NotFoundException;
use App\Exceptions\Container\ContainerException;

class Container implements ContainerInterface
{   
    private array $entries = [];

    public function get(string $id)
    {
        if (isset($this->entries[$id])) {
            $entry = $this->entries[$id];

            if (is_callable($this->entries[$id])) {
                return $entry($this);
            }

            $id = $entry;
        }

        return $this->resolve($id);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    public function set(string $id, callable|string $concrete)
    {
        $this->entries[$id] = $concrete;
    }

    public function resolve($id)
    {
        // 1. Inspect the class that we are trying to get from the container
        $reflectionClass = new \ReflectionClass($id);

        if (! $reflectionClass->isInstantiable()) {
            throw new ContainerException('Class "' . $id . '"is not instantiable');
        }

        // 2. Inspect constructor of the class
        $constructor = $reflectionClass->getConstructor();

        if (! $constructor) {
            return new $id;
        }

        // 3. Inspect the constructor parameters (dependencies)
        $params = $constructor->getParameters();

        if (! $params) {
            return new $id;
        }

        // 4. If the constructor parameter is a class then try to resolve that class using the container
        $dependencies = array_map(
            function (\ReflectionParameter $param) use ($id) {
                $name = $param->getName();
                $type = $param->getType();

                if (! $type) {
                    throw new ContainerException(
                        'Class "' . $id . '"has parameter"' . $name . '" without type hint'
                    );
                }

                if ($type instanceof \ReflectionUnionType || $type instanceof \ReflectionIntersectionType ) {
                    throw new ContainerException(
                        'Class "' . $id . '"has parameter"' . $name . '" without ReflectionUnionType type'
                    );
                }

                if ($type instanceof \ReflectionNamedType && ! $type->isBuiltin()) {
                    return $this->get($type->getName());
                }

                throw new ContainerException(
                    'Class "' . $id . '"has parameter"' . $name . '" is invalid for some reason'
                );
            },
            $params
        );

        return $reflectionClass->newInstanceArgs($dependencies);
    }
}