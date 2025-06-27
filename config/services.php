<?php

use Amar\Framework\Authentication\SessionAuthentication;
use Amar\Framework\Console\Application;
use Amar\Framework\Console\Command\MigrateDatabase;
use Amar\Framework\Controller\AbstractController;
use Amar\Framework\Dbal\ConnectionFactory;
use Amar\Framework\EventDispatcher\EventDispatcher;
use Amar\Framework\Http\Kernal;
use Amar\Framework\Http\Middleware\ExtractRouteInfo;
use Amar\Framework\Http\Middleware\RequestHandler;
use Amar\Framework\Http\Middleware\RequestHandlerInterface;
use Amar\Framework\Http\Middleware\RouteDispatch;
use Amar\Framework\Routing\Router;
use Amar\Framework\Routing\RouterInterface;
use Amar\Framework\Session\Session;
use Amar\Framework\Session\SessionInterface;
use Amar\Framework\Template\TwigFactory;
use App\Repository\UserRepository;
use Doctrine\DBAL\Connection;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\ReflectionContainer;
use Symfony\Component\Dotenv\Dotenv;


$dotenv = new Dotenv();
$dotenv->load(dirname(__DIR__) . '/.env');
//dd($_SERVER['APP_ENV']);

$container =  new \League\Container\Container();
$container->delegate(new ReflectionContainer(true));

// parameters for application config
$basePath = dirname(__DIR__);
$container->add('basePath', new StringArgument($basePath));
$routes = include $basePath  . '/routes/web.php';
$templatesPath = $basePath  . '/templates';
//$appEnv = 'dev';
$appEnv = $_SERVER['APP_ENV'];

$container->add('APP_ENV', new StringArgument($appEnv));

$databaseUrl = 'sqlite:///' . $basePath  . '/var/db.sqlite';

$container->add(
  'base-commands-namespace',
  new StringArgument("Amar\\Framework\\Console\\Command\\")
);

// services

$container->add(RouterInterface::class, Router::class);

$container->add(RequestHandlerInterface::class, RequestHandler::class)->addArgument($container);

$container->addShared(EventDispatcher::class);

$container->add(Kernal::class)
  ->addArguments([
    $container,
    RequestHandlerInterface::class,
    EventDispatcher::class
  ]);

$container->add(Application::class)->addArgument($container);
$container->add(\Amar\Framework\Console\Kernal::class)
  ->addArguments([$container, Application::class]);

// $container->addShared('filesystem-loader', FilesystemLoader::class)
//   ->addArgument(new StringArgument($templatesPath));

// $container->addShared('twig', Environment::class)
//   ->addArgument('filesystem-loader');

$container->addShared(SessionInterface::class, Session::class);

$container->add(
  'template-renderer-factory',
  TwigFactory::class
)->addArguments([
  SessionInterface::class,
  new StringArgument($templatesPath)
]);

$container->addShared('twig', function () use ($container) {
  return $container->get('template-renderer-factory')->create();
});

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
)->addArguments([
  Connection::class,
  new StringArgument($basePath . '/migrations')
]);

$container->add(RouteDispatch::class)->addArguments(
  [
    RouterInterface::class,
    $container
  ]
);

$container->add(SessionAuthentication::class)
  ->addArguments([UserRepository::class, SessionInterface::class]);

$container->add(ExtractRouteInfo::class)
  ->addArgument(new \League\Container\Argument\Literal\ArrayArgument($routes));



return $container;
