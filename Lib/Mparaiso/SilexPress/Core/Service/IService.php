<?php

namespace Mparaiso\SilexPress\Core\Service;

use Doctrine\Common\Persistence\ObjectRepository;
use Mparaiso\CodeGeneration\Service\ICRUDService;
use Mparaiso\SilexPress\Core\Model\Base as ModelBase;

/**
 * Class IService
 * @package Mparaiso\SilexPress\Core\Service
 * Interface for all database and model managers
 */
interface IService extends ObjectRepository, ICRUDService
{
    function remove(ModelBase $model);

    function persist(ModelBase $model);

    function count(array $query = array());
}
