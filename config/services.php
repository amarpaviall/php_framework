<?php

use Amar\Framework\Controller\AbstractController;
use Amar\Framework\Http\Kernal;
use Amar\Framework\Routing\Router;
use Amar\Framework\Routing\RouterInterface;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\ReflectionContainer;
use Symfony\Component\Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$dotenv = new Dotenv();
$dotenv->load(BASE_PATH . '/.env');
//dd($_SERVER['APP_ENV']);

$container =  new \League\Container\Container();
$container->delegate(new ReflectionContainer(true));
// parameters

$routes = include BASE_PATH . '/routes/web.php';
$templatesPath = BASE_PATH . '/templates';
//$appEnv = 'dev';
$appEnv = $_SERVER['APP_ENV'];

$container->add('APP_ENV', new StringArgument($appEnv));
// services

$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)->addMethodCall(
  'setRoute',
  [new ArrayArgument($routes)]
);

$container->add(Kernal::class)
  ->addArgument(RouterInterface::class)
  ->addArgument($container);

$container->addShared('filesystem-loader', FilesystemLoader::class)
  ->addArgument(new StringArgument($templatesPath));

$container->addShared('twig', Environment::class)
  ->addArgument('filesystem-loader');

$container->add(AbstractController::class);
$container->inflector(AbstractController::class)
  ->invokeMethod('setContainer', [$container]);


return $container;
