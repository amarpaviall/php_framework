<?php

namespace Amar\Framework\Routing;

use Amar\Framework\Http\Response;
use Amar\Framework\Http\Request;

interface RouterInterface
{

  public function dispatch(Request $request): array;

  public function setRoute(array $routes): void;
}
