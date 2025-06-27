<?php

namespace Amar\Framework\Http\Middleware;

use Amar\Framework\Http\Request;
use Amar\Framework\Http\Response;
use Amar\Framework\Http\TokenMismatchException;

class VerifyCsrfToken implements MiddlewareInterface
{
  public function process(Request $request, RequestHandlerInterface $requestHandler): Response
  {
    // Proceed if not state change request
    if (!in_array($request->getMethod(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
      return $requestHandler->handle($request);
    }
    // Retrieve the tokens
    $tokenFromSession = $request->getSession()->get('csrf_token');
    $tokenFromRequest = $request->input('_token');
    //$tokenFromRequest = 'fake_csrf_token'; // For testing purposes, replace with actual token retrieval logic

    // Throw an exception on mismatch
    if (!hash_equals($tokenFromSession, $tokenFromRequest)) {
      //dd($tokenFromRequest, $tokenFromSession);

      // Throw an exception
      $exception = new TokenMismatchException("Your request could not be validated. Please try again");
      $exception->setStatusCode(Response::HTTP_FORBIDDEN);
      throw $exception;
    }

    // Proceed with the request if the CSRF token is valid
    return $requestHandler->handle($request);
  }
}
