<?php
/**
 * Created by PhpStorm.
 * User: zakir
 * Date: 6/30/18
 * Time: 2:03 AM
 */

namespace WebApp\Repository\Base;

use PDO;
use WebApp\DB\Connection;

abstract class BaseRepository
{
    /**
     * @var \PDO
     */
    protected $connection;

    /**
     * BaseRepository constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->connection = Connection::getInstance()->getConnection();
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $query = 'SELECT * FROM ' . $this->getTableName();
        $result = $this->connection->query($query);

        return $result->fetchAll(PDO::FETCH_CLASS, $this->getClassName());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        $query = 'SELECT * FROM ' . $this->getTableName() . ' WHERE id = ' . $id;
        $result = $this->connection->query($query);

        return $result ? $result->fetchObject($this->getClassName()) : null;
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

    public function insert($data)
    {
        $tableFields = $this->getTableFields();
        $query = 'INSERT INTO ' . $this->getTableName() . ' ( ' . implode(',', $tableFields) . ' ) ' .
                 'VALUES (' . "'" . implode("','", $data) . "'" . ')';

        return $this->connection->query($query);
    }

    public function update($data, $id)
    {
        $tableFields = $this->getTableFields();
        $query = 'UPDATE ' . $this->getTableName() . ' SET ';
        $set = [];
        foreach ($tableFields as $field) {
            $set []= $field . '=\'' . $data[$field] . '\'';
        }

        $query .= implode(', ',$set) . ' WHERE id = ' . $id;

        return $this->connection->query($query);
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

    /**
     * @return array
     */
    protected function getTableFields(): array
    {
        $query = $this->connection->query('DESCRIBE ' . $this->getTableName());
        $tableFields = $query->fetchAll(PDO::FETCH_COLUMN);
        unset($tableFields[0]);

        return $tableFields;
    }
}