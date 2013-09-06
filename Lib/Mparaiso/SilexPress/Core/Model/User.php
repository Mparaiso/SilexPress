<?php

namespace Mparaiso\SilexPress\Core\Model;

use Model\Entity\Base as EntityBase;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

class User extends EntityBase implements AdvancedUserInterface
{

    protected $isCredentialsNonExpired = true;
    protected $isEnabled = true;
    protected $isAccountNonLocked = true;
    protected $isAccountNonExpired = true;
    protected $salt;
    protected $_id;
    protected $username;
    protected $firstname;
    protected $lastname;
    protected $password;
    protected $address;
    protected $email;
    protected $roles;
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

    /**
     * {@inheritdoc}
     */
    public function isAccountNonExpired()
    {
        return $this->isAccountNonExpired;
    }

    /**
     * {{@inheritdoc}
     */
    public function isAccountNonLocked()
    {
        return $this->isAccountNonLocked;
    }

    /**
     * {@inheritdoc}
     */
    public function isCredentialsNonExpired()
    {
        return $this->isCredentialsNonExpired;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     *
     * @return void
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function getIsAccountNonExpired()
    {
        return $this->isAccountNonExpired;
    }

    public function setIsAccountNonExpired($isAccountNonExpired)
    {
        $this->isAccountNonExpired = $isAccountNonExpired;
    }

    public function getIsAccountNonLocked()
    {
        return $this->isAccountNonLocked;
    }

    public function setIsAccountNonLocked($isAccountNonLocked)
    {
        $this->isAccountNonLocked = $isAccountNonLocked;
    }

    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;
    }

    public function getIsCredentialsNonExpired()
    {
        return $this->isCredentialsNonExpired;
    }

    public function setIsCredentialsNonExpired($isCredentialsNonExpired)
    {
        $this->isCredentialsNonExpired = $isCredentialsNonExpired;
    }
}

