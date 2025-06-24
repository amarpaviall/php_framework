<?php

namespace App\Controller;

use Amar\Framework\Controller\AbstractController;
use Amar\Framework\Http\Request;
use Amar\Framework\Http\Response;
use App\Entity\Post;

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

  public function store(): void
  {
    $title = $this->request->postParams['title'];
    $body = $this->request->postParams['body'];

    $post = Post::create($title, $body);
    dd($post);
  }
}
