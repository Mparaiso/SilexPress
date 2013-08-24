<?php

namespace Mparaiso\SilexPress\Core\Service;

use MongoCollection;
use MongoDB;
use MongoId;
use Mparaiso\SilexPress\Core\Decorator\Cursor;

class Base implements IService
{
    /**
     * @var String
     */
    protected $className;
    /**
     * @var MongoDB
     */
    protected $connection;
    /**
     * @var String
     */
    protected $collectionName;
    /**
     * @var MongoCollection
     */
    protected $collection;

    /**
     * @param MongoDB $connection
     * @param String $collectionName
     * @param String $className
     */
    function __construct(MongoDB $connection, $collectionName, $className)
    {
        $this->className = $className;
        $this->collectionName = $collectionName;
        $this->connection = $connection;
    }

    /**
     * @return MongoCollection
     */
    protected function getCollection()
    {
        if (!$this->collection)
            $this->collection = $this->connection->selectCollection($this->collectionName);
        return $this->collection;
    }

    /**
     * Finds an object by its primary key / identifier.
     *
     * @param int $id The identifier.
     * @return object The object.
     */
    function find($id)
    {
        return $this->findOneBy(array("_id" => new MongoId($id)));
    }

    /**
     * Finds all objects in the repository.
     *
     * @return mixed The objects.
     */
    function findAll()
    {
        return $this->findBy(array());
    }

    /**
     * Finds objects by a set of criteria.
     *
     * Optionally sorting and limiting details can be passed. An implementation may throw
     * an UnexpectedValueException if certain values of the sorting or limiting details are
     * not supported.
     *
     * @throws \UnexpectedValueException
     * @param array $criteria
     * @param array|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return mixed The objects.
     */
    function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $cursor = $this->getCollection()->find($criteria)->sort($orderBy)->skip((int)$limit * (int)$offset)->limit($limit);
        if ($cursor)
            return new Cursor($cursor, $this->className);
    }

    /**
     * Finds a single object by a set of criteria.
     *
     * @param array $criteria
     * @return object The object.
     */
    function findOneBy(array $criteria)
    {
        $result = $this->getCollection()->findOne($criteria);
        if ($result)
            return new $this->className($result);
    }

    /**
     * @param $model
     * @return bool
     */
    function persist($model)
    {
        return $this->getCollection()->update(array("_id" => $model["_id"]), $model, array("upsert" => true));
    }

    /**
     * @param $model
     * @return mixed
     */
    function remove($model)
    {
        return $this->getCollection()->remove(array("_id" => $model["_id"]));
    }

    /**
     * Returns the class name of the object managed by the repository
     *
     * @return string
     */
    function getClassName()
    {
        return $this->className;
    }
}
