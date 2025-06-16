<?php declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

require_once dirname(__DIR__)."/vendor/autoload.php";

use Amar\Framework\Http\Kernal;
use Amar\Framework\Http\Request;
use Amar\Framework\Routing\Router;

$request = Request::createFromGlobals();

$router = new Router();
$kernal = new Kernal($router);
$response = $kernal->handle($request);
$response->send();
