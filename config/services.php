<?php

use Amar\Framework\Http\Kernal;
use Amar\Framework\Routing\Router;
use Amar\Framework\Routing\RouterInterface;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\ReflectionContainer;

$container =  new \League\Container\Container();
$container->delegate(new ReflectionContainer(true));
// parameters

$routes = include BASE_PATH . '/routes/web.php';

// services

$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)->addMethodCall(
  'setRoute',
  [new ArrayArgument($routes)]
);

$container->add(Kernal::class)
  ->addArgument(RouterInterface::class)
  ->addArgument($container);

return $container;
