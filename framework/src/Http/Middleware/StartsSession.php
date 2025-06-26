<?php // framework/src/Http/Middleware/Success.php

namespace Amar\Framework\Http\Middleware;

use Amar\Framework\Http\Request;
use Amar\Framework\Http\Response;
use Amar\Framework\Session\SessionInterface;

class StartsSession implements MiddlewareInterface
{
  public function __construct(
    private SessionInterface $session,
    private string $apiPrefix = '/api/'
  ) {}
  public function process(Request $request, RequestHandlerInterface $requestHandler): Response
  {
    if (!str_starts_with($request->getPathInfo(), $this->apiPrefix)) {
      $this->session->start();

      $request->setSession($this->session);
    }
    return $requestHandler->handle($request);
  }
}
