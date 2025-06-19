<?php

namespace Amar\Framework\Controller;

use Amar\Framework\Http\Response;
use Psr\Container\ContainerInterface;

class AbstractController
{
  protected ?ContainerInterface $container = null;
  public function setContainer(ContainerInterface $container): void
  {
    $this->container = $container;
  }

  public function render(string $template, array $parameters, ?Response $response = null): Response
  {
    $content = $this->container->get('twig')->render($template, $parameters);

    $response ??= new Response();

    $response->setContent($content);
    return $response;
  }
}
