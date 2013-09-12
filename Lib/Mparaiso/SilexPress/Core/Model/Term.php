<?php

namespace Mparaiso\SilexPress\Core\Model;

class Term extends Base
{
    /* parent,count,description,taxonomy,_id,name,slug,term_group,order */

    function getTaxonomy()
    {
        return $this["taxonomy"];
    }

    function setTaxonomy($taxonomy)
    {
        $this["taxonomy"] = $taxonomy;
    }

    function getName()
    {
        return $this->__get("name");
    }

    function setName($name)
    {
        $this->__set("name", $name);
    }

    function __toString()
    {
        return (string)$this->getName();
    }
}