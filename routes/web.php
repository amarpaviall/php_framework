<?php

use Amar\Framework\Http\Middleware\Authenticate;
use Amar\Framework\Http\Middleware\Guest;
use App\Controller\HomeController;
use App\Controller\PostController;
use Amar\Framework\Http\Response;
use App\Controller\DashboardController;
use App\Controller\RegistrationController;
use App\Controller\LoginController;

return [
  ['GET', '/', [HomeController::class, 'index']],
  ['GET', '/posts/{id:\d+}', [PostController::class, 'show']],
  ['GET', '/posts', [PostController::class, 'create']],
  ['POST', '/posts', [PostController::class, 'store']],

  ['GET', '/register', [
    RegistrationController::class,
    'index',
    [
      Guest::class
    ]
  ]],

  ['POST', '/register', [RegistrationController::class, 'register']],

  ['GET', '/login', [
    LoginController::class,
    'index',
    [
      Guest::class
    ]
  ]],

  ['POST', '/login', [LoginController::class, 'login']],

  [
    'GET',
    '/dashboard',
    [DashboardController::class, 'index', [
      Authenticate::class
    ]]

  ],

  [
    'GET',
    '/logout',
    [
      \App\Controller\LoginController::class,
      'logout',
      [
        Authenticate::class
      ]
    ]
  ],

  ['GET', '/hello/{name:.+}', function (string $name) {
    return new Response("Hello $name");
  }],

];
