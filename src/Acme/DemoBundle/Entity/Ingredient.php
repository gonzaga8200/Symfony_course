<?php

namespace Acme\DemoBundle\Entity;
class Ingredient {
    private  $id;
    private  $name;

    /**
     * Get id
     *
     * @return integer 
     */
    public function __construct($name) {
        $this->name = $name;       
    }
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Ingredient
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
}
