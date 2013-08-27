<?php

namespace Mparaiso\SilexPress\Core\Service;

use Doctrine\Common\Persistence\ObjectRepository;
use Mparaiso\CodeGeneration\Service\ICRUDService;

/**
 * Class IService
 * @package Mparaiso\SilexPress\Core\Service
 * Interface for all database and model managers
 */
interface IService extends ObjectRepository, ICRUDService
{
    function remove($model);

    function persist($model);

    function count(array $query = array());
}
