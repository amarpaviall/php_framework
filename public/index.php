<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . "/vendor/autoload.php";

$container = require BASE_PATH . "/config/services.php";

use Amar\Framework\Http\Kernal;
use Amar\Framework\Http\Request;


$request = Request::createFromGlobals();

$kernal = $container->get(Kernal::class);

$response = $kernal->handle($request);

//dd($response);
$response->send();

$kernal->terminate($request, $response);

//dd($_SESSION);
