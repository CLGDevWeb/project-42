<?php

namespace Framework\Tests;

use Framework\Container\Container;
use Framework\Container\ContainerException;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function test_a_service_can_be_retrived_from_the_container(): void
    {
        $container = new Container();

        $container->add('dependant-class', DependantClass::class);

        $this->assertInstanceOf(DependantClass::class, $container->get('dependant-class'));
    }

    public function test_a_ContainerException_is_trhown_if_a_service_can_not_be_found(): void
    {
        $container = new Container();

        $this->expectException(ContainerException::class);
        
        $container->add('unknown-class');
    }

    public function test_can_check_if_the_container_has_a_service(): void
    {
        $container = new Container();

        $container->add('dependant-class', DependantClass::class);

        $this->assertTrue($container->has('dependant-class'));
        $this->assertFalse($container->has('unknown-class'));
    }

    public function test_services_can_be_recursively_autowired(): void
    {
        $container = new Container();

        $dependantService = $container->get(DependantClass::class);
        $dependancyService = $dependantService->getDependency();

        $this->assertInstanceOf(DependencyClass::class, $dependancyService);
        $this->assertInstanceOf(SubDependencyClass::class, $dependancyService->getSubDependency());
    }
}