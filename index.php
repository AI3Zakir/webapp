<?php
/**
 * Created by PhpStorm.
 * User: zakir
 * Date: 6/29/18
 * Time: 10:32 PM
 */


/**
 * @param $dir
 * @param int $depth
 */
foreach (glob('src/*/*.php') as $filename)
{
    require $filename;
}

$dbConfigs = include 'config/db.php';

define('DATABASE_HOST', $dbConfigs['host']);
define('DATABASE_NAME', $dbConfigs['name']);
define('DATABASE_USER', $dbConfigs['user']);
define('DATABASE_PASS', $dbConfigs['pass']);

$connectionInstance = \DB\Connection::getInstance();
try {
    $connection = $connectionInstance->getConnection();
} catch (Exception $e) {
    echo $e->getMessage();
}

$newsRepository = new Repository\NewsRepository($connection);
$newsRepository->getAll();
echo "Hello World";