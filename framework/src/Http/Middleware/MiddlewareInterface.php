<?php

namespace Amar\Framework\Http\Middleware;

use Amar\Framework\Http\Request;
use Amar\Framework\Http\Response;

interface MiddlewareInterface
{
  public function process(Request $request, RequestHandlerInterface $requestHandler): Response;
}
