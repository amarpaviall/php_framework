<?php

namespace App\Controller;

use Amar\Framework\Controller\AbstractController;
use Amar\Framework\Http\Response;
use App\Widget;
use Twig\Environment;

class HomeController extends AbstractController
{

  public function __construct(private Widget $widget) {}
  public function index(): Response
  {
    dd($this->container->get('twig'));
    $content = "<h1>Hello {$this->widget->name}</h1>";
    return new Response($content);
  }
}
