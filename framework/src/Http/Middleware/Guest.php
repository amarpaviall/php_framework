<?php

namespace Amar\Framework\Http\Middleware;

use Amar\Framework\Authentication\SessionAuthentication;
use Amar\Framework\Http\RedirectResponse;
use Amar\Framework\Http\Request;
use Amar\Framework\Http\Response;
use Amar\Framework\Session\SessionInterface;

class Guest implements MiddlewareInterface
{
  public function __construct(private SessionInterface $session) {}

  public function process(Request $request, RequestHandlerInterface $requestHandler): Response
  {
    $this->session->start();

    if ($this->session->has(SessionAuthentication::AUTH_KEY)) {
      return new RedirectResponse('/dashboard');
    }

    return $requestHandler->handle($request);
  }
}
