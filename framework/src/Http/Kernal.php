<?php

declare(strict_types=1);

namespace Amar\Framework\Http;

use Amar\Framework\Http\Middleware\RequestHandlerInterface;
use Amar\Framework\Routing\RouterInterface;
use Doctrine\DBAL\Connection;
use Exception;
use Psr\Container\ContainerInterface;

class Kernal
{
  private string $appEnv;
  public function __construct(
    private RouterInterface $router,
    private ContainerInterface $container,
    private RequestHandlerInterface $requestHandler
  ) {
    $this->appEnv = $this->container->get('APP_ENV');
  }
  public function handle(Request $request): Response
  {
    try {
      //dd($this->container->get(Connection::class));
      //throw new Exception('EXCEPTION IS KERNAL');

      $response = $this->requestHandler->handle($request);
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

  public function terminate(Request $request, Response $response): void
  {
    $request->getSession()?->clearFlash();
  }
}
