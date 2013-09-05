<?php

namespace Model\Entity;

class User extends Base
{

    protected $_id = null;
    protected $username = null;
    protected $firstname = null;
    protected $lastname = null;
    protected $password = null;
    protected $address = null;
    protected $email = null;
    protected $roles = array('ROLE_WRITER');
    protected $enabled = true;
    protected $userNonExpired = true;
    protected $credentialsNonExpired = true;
    protected $userNonLocked = true;
    protected $ip;


    public function getId()
    {
        return $this->_id;
    }

    public function setId($id)
    {
        $this->_id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

}

