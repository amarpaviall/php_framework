<?php

namespace App\Controller;

use Amar\Framework\Controller\AbstractController;
use Amar\Framework\Http\Response;

class DashboardController extends AbstractController
{
  public function index(): Response
  {
    return $this->render('dashboard.html.twig');
  }
}
