<?php

namespace Amar\Framework\Tests;

use Amar\Framework\Container\Container;
use Amar\Framework\Container\ContainerException;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{

  public function test_a_service_can_be_retrieved_from_container()
  {
    //$this->assertTrue(true);
    // Setup
    $container = new Container();

    // Do something
    // id string, concrete class name string | object
    $container->add('dependant-class', DependantClass::class);

    // Make assertions
    $this->assertInstanceOf(DependantClass::class, $container->get('dependant-class'));
  }

  public function test_a_ContainerException_is_thrown_if_a_service_cannot_be_found()
  {
    // Setup
    $container = new Container();

    // Expect exception
    $this->expectException(ContainerException::class);

    // Do something
    $container->add('foobar');
  }

  public function test_container_has_a_service()
  {
    $container = new Container();
    $container->add('dependant-class', DependantClass::class);

    $this->assertTrue($container->has('dependant-class'));
    $this->assertFalse($container->has('non-existent-class'));
  }

  public function test_services_can_be_recursively_autowired()
  {
    $container = new Container();
    //$container->add('dependant-class', DependantClass::class);

    $dependantService  = $container->get(DependantClass::class);

    $dependancyService = $dependantService->getDependency();

    $this->assertInstanceOf(DependencyClass::class, $dependancyService);
    $this->assertInstanceOf(SubDependencyClass::class, $dependancyService->getSubDependency());
  }
}
