<?php declare(strict_types=1);

namespace Amar\Framework\Http;

use Amar\Framework\Routing\Router;

class Kernal 
{
 public function __construct(private Router $router) {

 }
  public function handle(Request $request) : Response
  {
    try {
      [$routeHandler, $vars] = $this->router->dispatch($request);

    $response = call_user_func_array($routeHandler, $vars);
    } catch (\Exception $e) {
      $response = new Response($e->getMessage(), 400);
    }
    
   // dd($response) ;

    return $response;
  }
}
