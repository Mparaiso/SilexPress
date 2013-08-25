<?php

namespace Mparaiso\SilexPress\Core\Service;

use MongoCollection;
use MongoCursor;
use MongoDB;
use MongoId;
use Mparaiso\SilexPress\Core\Decorator\Cursor;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Base implements IService
{
    /**
     * @var EventDispatcherInterface
     */
    public $dispatcher;
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

    function setEventDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    function getEventDispatcher()
    {
        return $this->dispatcher;
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
        return new Cursor($this->getCollection()->find(), $this->className);
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
     * @return MongoCursor
     */
    function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $cursor = $this->getCollection()->find($criteria);
        if ($orderBy)
            $cursor->sort($orderBy);
        if ($limit && $offset)
            $cursor->skip((int)$limit * (int)$offset);
        if ($limit)
            $cursor->limit($limit);
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
        if (isset($model["_id"])) {
            $result = $this->getCollection()->update(array("_id" => $model["_id"]), $model, array("upsert" => true));
        } else {
            $result = $this->getCollection()->insert($model);
        }
        return $result;
    }


    /**
     * @param $model
     * @return mixed
     */
    function remove($model)
    {
        return $this->getCollection()->remove(array("_id" => new MongoId($model["_id"])));
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

    public function count(array $query = array())
    {
        return $this->getCollection()->count($query);
    }
}
