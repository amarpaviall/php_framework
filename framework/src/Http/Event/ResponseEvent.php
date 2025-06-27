<?php // framework/src/Http/Event/ResponseEvent.php

namespace Amar\Framework\Http\Event;

use Amar\Framework\EventDispatcher\Event;
use Amar\Framework\Http\Request;
use Amar\Framework\Http\Response;

class ResponseEvent extends Event
{
  public function __construct(
    private Request $request,
    private Response $response
  ) {}

  public function getRequest(): Request
  {
    return $this->request;
  }

  public function getResponse(): Response
  {
    return $this->response;
  }
}
