<?php

use App\Controller\HomeController;
use App\Controller\PostController;
use Amar\Framework\Http\Response;

return [
  ['GET', '/', [HomeController::class, 'index']],
  ['GET', '/posts/{id:\d+}', [PostController::class, 'show']],
  ['GET', '/posts', [PostController::class, 'create']],
  ['POST', '/posts', [PostController::class, 'store']],
  ['GET', '/hello/{name:.+}', function (string $name) {
    return new Response("Hello $name");
  }],

];
