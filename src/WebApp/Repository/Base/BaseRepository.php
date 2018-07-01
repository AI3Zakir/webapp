<?php
/**
 * Created by PhpStorm.
 * User: zakir
 * Date: 6/30/18
 * Time: 2:03 AM
 */

namespace WebApp\Repository\Base;

use PDO;
use ReflectionClass;
use ReflectionProperty;
use WebApp\DB\Connection;

/**
 * Class BaseRepository
 * @package WebApp\Repository\Base
 */
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
        $query = 'SELECT * FROM ' . $this->getTableName() . ' WHERE id = :id';
        $statement = $this->connection->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $result = $statement->execute();

        return $result ? $statement->fetchObject($this->getClassName()) : null;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteById($id)
    {
        $query = 'DELETE FROM ' . $this->getTableName() . ' WHERE id = :id';
        $statement = $this->connection->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        return $statement->execute();
    }

    /**
     * @param $data
     * @return bool
     */
    public function insert($data): bool
    {
        $tableFields = $this->getModelFields();
        $query = 'INSERT INTO ' . $this->getTableName() . ' ( ' . implode(',', $tableFields) . ' ) ' .
                 'VALUES (' . implode(',', preg_filter('/^/', ':', $tableFields) ). ')';


        $statement = $this->connection->prepare($query);
        foreach ($tableFields as $tableField) {
            $statement->bindValue(':' . $tableField, $data[$tableField]);
        }

        return $statement->execute();
    }

    /**
     * @param $data
     * @param $id
     * @return bool
     */
    public function update($data, $id): bool
    {
        $tableFields = $this->getModelFields();
        $query = 'UPDATE ' . $this->getTableName() . ' SET ';
        $set = [];
        foreach ($tableFields as $field) {
            $set []= $field . '=:' . $field;
        }

        $query .= implode(', ',$set) . ' WHERE id = :id';
        $statement = $this->connection->prepare($query);
        foreach ($tableFields as $tableField) {
            $statement->bindValue(':' . $tableField, $data[$tableField]);
        }
        $statement->bindValue(':id', $id);

        return $statement->execute();
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
        $repository = explode('\\', get_called_class());

        return 'WebApp\\Model\\' . str_replace('Repository', '', end($repository));
    }

    /**
     * @return array
     */
    protected function getModelFields(): array
    {
        try {
            $reflection = new ReflectionClass($this->getClassName());
        } catch (\ReflectionException $e) {
            echo $e->getMessage();
        }
        $reflectionProperties = $reflection->getProperties(ReflectionProperty::IS_PRIVATE);
        $fields = [];
        foreach ($reflectionProperties as $property) {
            if ($property->name !== 'id') {
                $fields[] = $property->name;
            }
        }

        return $fields;
    }
}