<?php

namespace Amar\Framework\Tests;

class DependantClass
{

  public function __construct(
    private DependencyClass $dependency
  ) {}

  public function getDependency()
  {
    return $this->dependency;
  }
}
