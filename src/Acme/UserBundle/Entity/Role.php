<?php

/// src/Acme/Bundle/UserBundle/Entity/Role.php
namespace Acme\UserBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;

class Role implements RoleInterface
{
    
    private $id;

    
    private $name;

    
    private $role;

    
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    
    public function getRole()
    {
        return $this->role;
    }

    // ... getters and setters for each property
}

?>
