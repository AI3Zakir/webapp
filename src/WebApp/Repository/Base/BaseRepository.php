<?php
/**
 * Created by PhpStorm.
 * User: zakir
 * Date: 6/30/18
 * Time: 2:03 AM
 */

namespace WebApp\Repository\Base;

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

    /**
     * @return array
     */
    public function getAll(): array
    {
        $query = 'SELECT * FROM ' . $this->getTableName();
        $result = $this->connection->query($query);

        return $result->fetchAll(\PDO::FETCH_CLASS, $this->getClassName());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        $query = 'SELECT * FROM ' . $this->getTableName() . ' WHERE id = ' . $id;
        $result = $this->connection->query($query);

        return $result->fetchObject($this->getClassName());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteById($id)
    {
        $query = 'DELETE FROM ' . $this->getTableName() . ' WHERE id = ' . $id;

        return $this->connection->exec($query);
    }

    /**
     * @return string
     */
    protected function getTableName(): string
    {
        return strtolower(ltrim(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0',  str_replace('WebApp\Model\\', '', $this->getClassName())), '_'));
    }

    /**
     * @return string
     */
    protected function getClassName(): string
    {
        return 'WebApp\\Model\\' . str_replace('Repository', '', end(explode('\\', get_called_class())));
    }
}