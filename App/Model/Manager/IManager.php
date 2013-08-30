<?php

namespace Model\Manager\IManager{
	interface IManager{
		function getDB();
		function getCollection();
	}
}