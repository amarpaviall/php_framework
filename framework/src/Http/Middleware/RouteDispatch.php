<?php // framework/src/Http/Middleware/Success.php

namespace Amar\Framework\Http\Middleware;

use Amar\Framework\Http\Request;
use Amar\Framework\Http\Response;
use Amar\Framework\Routing\RouterInterface;
use Psr\Container\ContainerInterface;

class RouteDispatch implements MiddlewareInterface
{
  public function __construct(
    private RouterInterface $router,
    private ContainerInterface $container,
  ) {}
  public function process(Request $request, RequestHandlerInterface $requestHandler): Response
  {
    [$routeHandler, $vars] = $this->router->dispatch($request, $this->container);

    $response = call_user_func_array($routeHandler, $vars);

    return $response;
  }
}
