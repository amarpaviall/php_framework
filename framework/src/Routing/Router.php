<?php

namespace Amar\Framework\Routing;

use Amar\Framework\Controller\AbstractController;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Amar\Framework\Http\HttpException;
use Amar\Framework\Http\HttpRequestMethodException;
use function FastRoute\simpleDispatcher;
use Amar\Framework\Http\Request;
use Psr\Container\ContainerInterface;

class Router implements RouterInterface
{
  private array $routes;
  public function dispatch(Request $request, ContainerInterface $container): array
  {

    $routeInfo = $this->extractRouteInfo($request);

    //dd($routeInfo);
    [$handler, $vars] = $routeInfo;

    if (is_array($handler)) {
      [$controllerId, $method] = $handler;
      $controller = $container->get($controllerId);
      if (is_subclass_of($controller, AbstractController::class)) {
        $controller->setRequest($request);
      }
      $handler = [$controller, $method];

      //dd($handler);
    }


    return [$handler, $vars];
  }

  public function setRoute(array $routes): void
  {
    $this->routes = $routes;
  }

  private function extractRouteInfo(Request $request)
  {
    // Create a dispatcher
    $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {

      // $routes = include BASE_PATH . '/routes/web.php';

      foreach ($this->routes as $route) {
        $routeCollector->addRoute(...$route);
      }
    });

    // Dispatch a URI, to obtain the route info
    $routeInfo = $dispatcher->dispatch(
      $request->getMethod(),
      $request->getPathInfo()
    );


    switch ($routeInfo[0]) {
      case Dispatcher::FOUND:
        return [$routeInfo[1], $routeInfo[2]]; // routeHandler, vars
      case Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = implode(', ', $routeInfo[1]);
        $e = throw new HttpRequestMethodException("The allowed methods are $allowedMethods");
        $e->setStatusCode(405);
        throw $e;
      default:
        $e = throw new HttpException('Not found');
        $e->setStatusCode(404);
        throw $e;
    }
  }
}
