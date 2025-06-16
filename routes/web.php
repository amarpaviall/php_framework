<?php

use App\Controller\HomeController;
use App\Controller\PostController;
use Amar\Framework\Http\Response; 

return [
  ['GET', '/', [HomeController::class, 'index']],
  ['GET', '/post/{id:\d+}', [PostController::class, 'show']],
  ['GET', '/hello/{name:.+}', function(string $name){
    return new Response("Hello $name");
  }],

];