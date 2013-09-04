<?php

namespace Mparaiso\SilexPress\Core\Service;
/**
 * Class Post
 * @package Mparaiso\SilexPress\Core\Service
 * Manage Post types
 */
class Post extends Base
{
    protected $posttype = "post";

    function persist($model)
    {
        $model->setPostModified(new \MongoDate());
        if ("NULL" === $model->getPostDate()) {
            $model->setPostDate(new \MongoDate());
        }
        $model->setPostType($this->posttype);
        return parent::persist($model);
    }

    function findByDateDesc($limit = null, $offset = null)
    {
        return $this->findBy(array(), array("post_date" => -1), $limit, $offset);
    }

    function byCategoryId($id, array $order = array("post_date" => -1))
    {
        return $this->findBy(
            array("categories" => array('$in' => array(new \MongoId($id)))), $order
        );
    }

    function byTagName($tagname, array $order = array("post_date" => -1))
    {
        return $this->findBy(
            array("tags" => array('$in' => array($tagname))), $order
        );
    }

    function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $criteria["post_type"] = $this->posttype;
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    public function count(array $query = array())
    {
        $query["post_type"] = $this->posttype;
        return parent::count($query);
    }

    function getPosttype()
    {
        return $this->posttype;
    }

    function setPosttype($posttype)
    {
        $this->posttype = $posttype;
    }


}