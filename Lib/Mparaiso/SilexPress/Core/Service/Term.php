<?php

namespace Mparaiso\SilexPress\Core\Service;
/**
 * Class Term
 * @package Mparaiso\SilexPress\Core\Service
 * Manage Term types
 */
class Term extends Base
{

    protected $taxonomy;

    function persist($model)
    {
        $model->setTaxonomy($this->taxonomy);
        return parent::persist($model);
    }

    function findOneBy(array $criteria){
        $criteria["taxonomy"] =$this->taxonomy;
        return parent::findOneBy($criteria);
    }

    function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $criteria["taxonomy"] = $this->taxonomy;
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    public function count(array $query = array())
    {
        $query["taxonomy"] = $this->taxonomy;
        return parent::count($query);
    }

    function getTaxonomy()
    {
        return $this->taxonomy;
    }

    function setTaxonomy($taxonomy)
    {
        $this->taxonomy = $taxonomy;
    }

}