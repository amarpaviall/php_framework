<?php

namespace Amar\Framework\Http\Middleware;

use Amar\Framework\Http\Request;
use Amar\Framework\Http\Response;

class Authenticate implements MiddlewareInterface
{
  private bool $authenticated = true;
  public function process(Request $request, RequestHandlerInterface $requestHandler): Response
  {

    if (!$this->authenticated) {
      return new Response('Authentication failed!!', 401);
    }

    return $requestHandler->handle($request);
  }
}
