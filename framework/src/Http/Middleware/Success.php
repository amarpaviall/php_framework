<?php // framework/src/Http/Middleware/Success.php

namespace Amar\Framework\Http\Middleware;

use Amar\Framework\Http\Request;
use Amar\Framework\Http\Response;

class Success implements MiddlewareInterface
{
  public function process(Request $request, RequestHandlerInterface $requestHandler): Response
  {
    return new Response('OMG it worked!!', 200);
  }
}
