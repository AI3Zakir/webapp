<?php
/**
 * Created by PhpStorm.
 * User: zakir
 * Date: 6/30/18
 * Time: 2:03 AM
 */

namespace Repository\Base;

use Model\News;

abstract class BaseRepository
{
    /**
     * @var \PDO
     */
    protected $connection;

    /**
     * BaseRepository constructor.
     * @param $connection
     */
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getAll()
    {
        $query = 'SELECT * FROM ' . $this->getTableName();
        $result = $this->connection->query($query);

        return $result->fetchAll(\PDO::FETCH_CLASS, $this->getClassName());
    }

    protected function getTableName()
    {
        return strtolower(ltrim(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0',  str_replace('Model\\', '', $this->getClassName())), '_'));
    }

    protected function getClassName()
    {
        return 'Model\\' . str_replace('Repository', '', end(explode('\\', get_called_class())));
    }
}