<?php

namespace App\Controller;

use Amar\Framework\Http\Response;

class PostController {

  public function show(int $id) : Response {
    $content = "This is Post {$id}";
    return new Response($content);
  }
}