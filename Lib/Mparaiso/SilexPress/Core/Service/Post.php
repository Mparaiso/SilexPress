<?php

namespace Mparaiso\SilexPress\Core\Service;

class Post extends Base
{
    protected $posttype = "post";


    function persist($model)
    {
        $model->setPostType($this->posttype);
        return parent::persist($model);
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