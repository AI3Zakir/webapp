<?php
/**
 * Created by PhpStorm.
 * User: zakir
 * Date: 6/29/18
 * Time: 10:32 PM
 */

use WebApp\DB\Connection;


/**
 * @param $dir
 * @param int $depth
 */
$loader = require 'vendor/autoload.php';
$loader->addPsr4('WebApp\\', __DIR__);

$dbConfigs = include 'config/db.php';

define('DATABASE_HOST', $dbConfigs['host']);
define('DATABASE_NAME', $dbConfigs['name']);
define('DATABASE_USER', $dbConfigs['user']);
define('DATABASE_PASS', $dbConfigs['pass']);

$connectionInstance = Connection::getInstance();
try {
    $connection = $connectionInstance->getConnection();
} catch (Exception $e) {
    echo $e->getMessage();
}

$newsRepository = new WebApp\Repository\NewsRepository($connection);
var_dump($newsRepository->getAll());