<?php

declare(strict_types = 1);

use App\App;
use App\Config;
use App\Container;
use App\Controllers\HomeController;
use App\Controllers\TransactionsController;
use App\Controllers\GeneratorExampleController;
use App\Router;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

define('STORAGE_PATH', __DIR__ . '/../storage');
define('VIEW_PATH', __DIR__ . '/../views');

$container = new Container();
$router = new Router($container);

$router->registerRoutersFromControllerAttribute(
    [
        HomeController::class,
        TransactionsController::class,
        GeneratorExampleController::class
    ]
);

// $router
//     ->get('/', [HomeController::class, 'index'])
//     ->get('/transactions', [TransactionsController::class, 'getTransactions'])
//     ->get('/transactions/upload', [TransactionsController::class, 'getForm'])
//     ->post('/transactions/upload', [TransactionsController::class, 'uploadTransactions'])
//     ->get('/examples/generators', [GeneratorExampleController::class, 'index']);

(new App(
    $container,
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new Config($_ENV)
))->run();
