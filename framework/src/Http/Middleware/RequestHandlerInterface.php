<?php

namespace Amar\Framework\Http\Middleware;

use Amar\Framework\Http\Request;
use Amar\Framework\Http\Response;

interface RequestHandlerInterface
{
  public function handle(Request $request): Response;
}
