<?php

namespace Amar\Framework\Tests;

class DependencyClass
{
  public function __construct(
    private SubDependencyClass $subdependency
  ) {}

  public function getSubDependency()
  {
    return $this->subdependency;
  }
}
