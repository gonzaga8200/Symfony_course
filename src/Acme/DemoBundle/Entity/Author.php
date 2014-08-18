<?php

namespace Acme\DemoBundle\Entity;
class Author {
    
    private  $id;
    private  $name;
    private  $surname;
    

    /**
     * Get id
     *
     * @return integer 
     */
    
    public function __construct($name,$surname) {
        $this->name = $name;
        $this->surname = $surname;
        
        
    }
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Author
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

    /**
     * Set surname
     *
     * @param string $surname
     * @return Author
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }
}
