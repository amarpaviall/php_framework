<?php // framework/src/Http/Middleware/Success.php

namespace Amar\Framework\Http\Middleware;

use Amar\Framework\Http\Request;
use Amar\Framework\Http\Response;
use Amar\Framework\Session\SessionInterface;

class StartsSession implements MiddlewareInterface
{
  public function __construct(private SessionInterface $session) {}
  public function process(Request $request, RequestHandlerInterface $requestHandler): Response
  {
    $this->session->start();
    $request->setSession($this->session);
    return $requestHandler->handle($request);
  }
}
