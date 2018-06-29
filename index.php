<?php
/**
 * Created by PhpStorm.
 * User: zakir
 * Date: 6/29/18
 * Time: 10:32 PM
 */

$dbConfigs = include 'config/db.php';

define('DATABASE_HOST', $dbConfigs['host']);
define('DATABASE_NAME', $dbConfigs['name']);
define('DATABASE_USER', $dbConfigs['user']);
define('DATABASE_PASS', $dbConfigs['pass']);