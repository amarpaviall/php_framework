<?php

namespace App\Controller;

use Amar\Framework\Controller\AbstractController;
use Amar\Framework\Http\Response;

class PostController extends AbstractController
{

  public function show(int $id): Response
  {
    // $content = "This is Post {$id}";
    // return new Response($content);

    return $this->render('post.html.twig', [
      'postId' => $id
    ]);
  }

  public function create(): Response
  {
    return $this->render('create-post.html.twig');
  }
}
