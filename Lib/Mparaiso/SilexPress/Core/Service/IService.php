<?php

namespace Mparaiso\SilexPress\Core\Service;

use Doctrine\Common\Persistence\ObjectRepository;

interface IService extends ObjectRepository
{
    function remove($model);

    function persist($model);
}
