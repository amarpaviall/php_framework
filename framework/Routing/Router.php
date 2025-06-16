<?php

namespace Amar\Framework\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Amar\Framework\Http\HttpException;
use Amar\Framework\Http\HttpRequestMethodException;
use function FastRoute\simpleDispatcher;
use Amar\Framework\Http\Request;
 
class Router implements RouterInterface {
  
  public function dispatch(Request $request) :array {
    
   $routeInfo = $this->extractRouteInfo($request);

   //dd($routeInfo);
    [$handler, $vars] = $routeInfo;

    if (is_array($handler)) {
        [$controller, $method] = $handler;
        $handler = [new $controller, $method];
    }

    
    return [$handler, $vars];
  
  }

  private function extractRouteInfo(Request $request) {
    // Create a dispatcher
    $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {

      $routes = include BASE_PATH . '/routes/web.php';

      foreach ($routes as $route) {
        $routeCollector->addRoute(...$route);
      }
      
  });

  // Dispatch a URI, to obtain the route info
  $routeInfo = $dispatcher->dispatch(
      $request->getMethod(),
      $request->getPathInfo()
  );
 

   switch($routeInfo[0]){
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