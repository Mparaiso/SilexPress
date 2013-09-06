<?php
namespace Model\Manager{
  
  use Model\Entity\Comment;
  use Mparaiso\SilexPress\Core\Model\User;

  interface ISpamManager{

    function ipIsSpammer($ip);

  }
}