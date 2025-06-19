<?php

namespace Amar\Framework\Controller;

use Psr\Container\ContainerInterface;

class AbstractController
{
  protected ?ContainerInterface $container = null;
  public function setContainer(ContainerInterface $container): void
  {
    $this->container = $container;
  }
}
