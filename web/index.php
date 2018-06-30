<?php
/**
 * Created by PhpStorm.
 * User: zakir
 * Date: 6/29/18
 * Time: 10:32 PM
 */

$loader = require '../vendor/autoload.php';
$loader->addPsr4('WebApp\\', __DIR__);

$dbConfigs = include '../config/db.php';
$routes = include '../config/routes.php';

define('DATABASE_HOST', $dbConfigs['host']);
define('DATABASE_NAME', $dbConfigs['name']);
define('DATABASE_USER', $dbConfigs['user']);
define('DATABASE_PASS', $dbConfigs['pass']);

$router = new \WebApp\Core\Router($routes);
$webApp = new \WebApp\Core\Application($router);
$webApp->run();