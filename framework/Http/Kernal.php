<?php declare(strict_types=1);

namespace Amar\Framework\Http;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Kernal 
{
 
  public function handle(Request $request) : Response
  {
    // Create a dispatcher
    $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {

      $routes = include BASE_PATH . '/routes/web.php';

      //dd($routes);

      foreach ($routes as $route) {
        $routeCollector->addRoute(...$route);
         //dd($routeCollector);
      }
      // $routeCollector->addRoute('GET', '/', function() {
      //     $content = '<h1>Hello World</h1>';

      //     return new Response($content);
      // });

      // $routeCollector->addRoute('GET', '/posts/{id:\d+}', function($routeParams) {
      //     $content = "<h1>This is Post {$routeParams['id']}</h1>";

      //     return new Response($content);
      // });
  });

  // Dispatch a URI, to obtain the route info
  $routeInfo = $dispatcher->dispatch(
      //$request->server['REQUEST_METHOD'],
      //$request->server['REQUEST_URI'],
      $request->getMethod(),
      $request->getPathInfo()
  );
   
  //dd($routeInfo);
  
 // [$status, $handler, $vars] = $routeInfo;
 
  [$status, [$controller, $method], $vars] = $routeInfo;

  // $vars['id'] = (int) $vars['id'];
  // $response = (new $controller())->$method(...$vars);

  $response = call_user_func_array([new $controller, $method], $vars);
  //dd($vars);
  //dd($response);

    // Call the handler, provided by the route info, in order to create a Response
  return $response;
  
    //return $handler($vars);
  }
}
