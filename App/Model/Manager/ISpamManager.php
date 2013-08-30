<?php
namespace Model\Manager{
  
  use Model\Entity\Comment;
  use Model\Entity\User;

  interface ISpamManager{

    function ipIsSpammer($ip);

  }
}