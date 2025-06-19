<?php

namespace App\Controller;

use Amar\Framework\Http\Response;

class HomeController
{

  public function __construct() {}
  public function index(): Response
  {
    $content = '<h1>hello</h1>';
    return new Response($content);
  }
}
