<?php
/**
 * Created by PhpStorm.
 * User: zakir
 * Date: 6/30/18
 * Time: 1:21 AM
 */

namespace DB;


class Connection
{
    private $host = DATABASE_HOST;
    private $name = DATABASE_NAME;
    private $user = DATABASE_USER;
    private $pass = DATABASE_PASS;

    private static $instance;
    private $connection;

    /**
     * Get PDO connection.
     * @throws \PDOException
     * @throws \Exception
     */
    public function getConnection(): \PDO
    {
        try {
            $this->connection = new \PDO("mysql:host=$this->host;dbname=$this->name", $this->user, $this->pass);
            return $this->connection;
        } catch (\PDOException $exception) {
            throw  $exception;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @return Connection
     */
    public static function getInstance(): Connection
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * Override magic methods to ensure full singletone
     */
    public function __construct() {}
    public function __destruct(){}
    public function __clone() {}
    public function __wakeup() {}
}