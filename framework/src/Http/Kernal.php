<?php

declare(strict_types=1);

namespace Amar\Framework\Http;

use Amar\Framework\Routing\RouterInterface;
use Doctrine\DBAL\Connection;
use Exception;
use Psr\Container\ContainerInterface;

class Kernal
{
  private string $appEnv;
  public function __construct(
    private RouterInterface $router,
    private ContainerInterface $container
  ) {
    $this->appEnv = $this->container->get('APP_ENV');
  }
  public function handle(Request $request): Response
  {
    try {
      //dd($this->container->get(Connection::class));
      //throw new Exception('EXCEPTION IS KERNAL');

      [$routeHandler, $vars] = $this->router->dispatch($request, $this->container);

      $response = call_user_func_array($routeHandler, $vars);
    } catch (\Exception $exception) {
      $response = $this->createExceptionResponse($exception);
    }

    // dd($response) ;

    return $response;
  }

  /**
   * @throws  \Exception $exception
   */
  private function createExceptionResponse(\Exception $exception): Response
  {
    if (in_array($this->appEnv, ['dev', 'test'])) {
      throw $exception;
    }

    if ($exception instanceof HttpException) {
      return new Response($exception->getMessage(), $exception->getStatusCode());
    }

    return new Response('Server error', Response::HTTP_INTERNAL_SERVER_ERROR);
  }
}
