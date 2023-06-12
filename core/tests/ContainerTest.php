<?php

namespace Framework\Tests;

use Framework\Container\Container;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function test_a_service_can_be_retrived_from_the_container(): void
    {
        $container = new Container();

        $container->add('dependant-class', DependantClass::class);

        $this->assertInstanceOf(DependantClass::class, $container->get('dependant-class'));
    }
}