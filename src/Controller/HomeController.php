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

    $template = "<h1>Hello {{ name }}</h1>";
    return $this->render($template, [
      'name' => $this->widget->name
    ]);
  }
}
