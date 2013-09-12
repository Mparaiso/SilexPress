<?php
namespace Mparaiso\SilexPress\Core\DataAccessLayer;

interface IDatabase
{

    /**
     * Finds an object by its primary key / identifier.
     *
     * @param int $id
     *            The identifier.
     * @return object The object.
     */
    function find($id);

    /**
     * Finds all objects in the repository.
     *
     * @return mixed The objects.
     */
    function findAll();

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
    function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    /**
     * Finds a single object by a set of criteria.
     *
     * @param array $criteria            
     * @return object The object.
     */
    function findOneBy(array $criteria);

    /**
     *
     * @param
     *            $model
     * @return bool
     */
    function persist($model);

    /**
     *
     * @param
     *            $model
     * @return mixed
     */
    function remove($model);

    /**
     * Returns the class name of the object managed by the repository
     *
     * @return string
     */
    function getClassName();

    public function count(array $query = array());
}