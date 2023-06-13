<?php

namespace Framework\Container;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $services = [];
    
    public function add(string $id, string|object $concrete = null)
    {
        if ($concrete === null) {
            if (!class_exists($id)) {
                throw new ContainerException("Service {$id} could not be found");
            }

            $concrete = $id;
        }
        
        $this->services[$id] = $concrete;
    }
    
    public function get(string $id)
    {
        if (! $this->has($id)) {
            if (!class_exists($id)) {
                throw new ContainerException("Service {$id} could not be resolved");
            }

            $this->add($id);
        }

        $object = $this->resolve($this->services[$id]);
        
        return $object;
    }

    private function resolve(string|object $class): object
    {
        // 1. Instantiate a Reflection class
        $reflectionClass = new \ReflectionClass($class);
        
        // 2. Use Reflection to try to obtain a class constructor
        $constructor = $reflectionClass->getConstructor();

        // 3. If there is no constructor, simply instantiate
        if ($constructor === null) {
            return $reflectionClass->newInstance();
        }

        // 4. Get the constructor parameters
        $constructorParams = $constructor->getParameters();

        // 5. Obtain dependencies
        $classDependencies = $this->resolveClassDependencies($constructorParams);

        // 6. Instantiate with dependencies
        $service = $reflectionClass->newInstanceArgs($classDependencies);

        // 7. Return the object
        return $service;
    }

    private function resolveClassDependencies(array $reflectionParams): array
    {
        // 
        $classDependencies = [];

        /** @var \ReflectionParameter $param */
        foreach($reflectionParams as $param) {
            $serviceType = $param->getType();

            $service = $this->get($serviceType->getName());

            $classDependencies[] = $service;
        }

        return $classDependencies;
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->services);
    }
}