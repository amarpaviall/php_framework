<?php

namespace Amar\Framework\Routing;

use Amar\Framework\Http\Response;
use Amar\Framework\Http\Request;
use Psr\Container\ContainerInterface;

interface RouterInterface
{

  public function dispatch(Request $request, ContainerInterface $container): array;

  public function setRoute(array $routes): void;
}
