<?php

use Amar\Framework\Console\Application;
use Amar\Framework\Console\Command\MigrateDatabase;
use Amar\Framework\Controller\AbstractController;
use Amar\Framework\Dbal\ConnectionFactory;
use Amar\Framework\Http\Kernal;
use Amar\Framework\Routing\Router;
use Amar\Framework\Routing\RouterInterface;
use Doctrine\DBAL\Connection;
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

// parameters for application config

$routes = include BASE_PATH . '/routes/web.php';
$templatesPath = BASE_PATH . '/templates';
//$appEnv = 'dev';
$appEnv = $_SERVER['APP_ENV'];

$container->add('APP_ENV', new StringArgument($appEnv));

$databaseUrl = 'sqlite:///' . BASE_PATH . '/var/db.sqlite';

$container->add(
  'base-commands-namespace',
  new StringArgument("Amar\\Framework\\Console\\Command\\")
);

// services

$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)->addMethodCall(
  'setRoute',
  [new ArrayArgument($routes)]
);

$container->add(Kernal::class)
  ->addArgument(RouterInterface::class)
  ->addArgument($container);

$container->add(Application::class)->addArgument($container);
$container->add(\Amar\Framework\Console\Kernal::class)
  ->addArguments([$container, Application::class]);

$container->addShared('filesystem-loader', FilesystemLoader::class)
  ->addArgument(new StringArgument($templatesPath));

$container->addShared('twig', Environment::class)
  ->addArgument('filesystem-loader');

$container->add(AbstractController::class);
$container->inflector(AbstractController::class)
  ->invokeMethod('setContainer', [$container]);


//dd($databaseUrl);

// $container->add(ConnectionFactory::class)
//   ->addArguments([
//     new \League\Container\Argument\Literal\StringArgument($databaseUrl)
//   ]);
$container->add(ConnectionFactory::class)
  ->addArgument($databaseUrl); // just pass the string directly

$container->addShared(Connection::class, function () use ($container): Connection {
  return $container->get(ConnectionFactory::class)->create();
});

$container->add(
  'database:migrations:migrate',
  MigrateDatabase::class
)->addArgument(Connection::class);

return $container;
