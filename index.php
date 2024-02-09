<?php

//error_reporting(0);

use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use GuzzleHttp\Client;


require "./vendor/autoload.php";

// MEUS INCLUDES
require "./config/db.php";
require "./config/messages.php";
require "./config/themes.php";

require "./main/db-controller.php";
require "./main/main-controller.php";

require "./helpers/renderer.php";
require "./helpers/validator.php";
require "./helpers/tools.php";


$app = AppFactory::create();

$app->get('/', \MainController::class . ':unauthorized');


$app->group('/api', function (RouteCollectorProxy $group) {
    $group->get('/themes', \MainController::class . ':Themes');
    $group->post('/answers', \MainController::class . ':Answers');
});



$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', \MainController::class . ':unauthorized');

$app->run();
