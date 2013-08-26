<?php

namespace Mparaiso\SilexPress\Core\Model;

class Term extends Base{
	/* parent,count,description,taxonomy,_id,name,slug,term_group,order */
	function getId(){
		return $this["_id"];
	}

	function setId($id){
		$this["_id"]=$id;
	}

	function getTaxonomy(){
		return $this["taxonomy"];
	}

	function setTaxonomy($taxonomy){
		$this["taxonomy"] = $taxonomy;
	}
}