<?php

use App\Controller\HomeController;
use App\Controller\PostController;

return [
  ['GET', '/', [HomeController::class, 'index']],
  ['GET', '/post/{id:\d+}', [PostController::class, 'show']]
];