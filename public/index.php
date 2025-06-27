<?php

declare(strict_types=1);

use Amar\Framework\EventDispatcher\EventDispatcher;
use Amar\Framework\Http\Event\ResponseEvent;
use Amar\Framework\Http\Kernal;
use Amar\Framework\Http\Request;
use App\EventListener\ContentLengthListener;
use App\EventListener\InternalErrorListener;

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . "/vendor/autoload.php";

$container = require BASE_PATH . "/config/services.php";

// bootstrapping
require BASE_PATH . '/bootstrap/bootstrap.php';

$request = Request::createFromGlobals();

$kernal = $container->get(Kernal::class);

$response = $kernal->handle($request);

//dd($response);
$response->send();

$kernal->terminate($request, $response);

//dd($_SESSION);
