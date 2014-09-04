<?php

namespace Acme\DemoBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

class Author {
    
    private  $id;
    private  $name;
    private  $surname;
    
    protected $recipes;
    

    /**
     * Get id
     *
     * @return integer 
     */
    
    
    public function getRecipes(){
        return $this->recipes;
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

    /**
     * Add recipes
     *
     * @param \Acme\DemoBundle\Entity\Recipe $recipes
     * @return Author
     */
    public function addRecipe(\Acme\DemoBundle\Entity\Recipe $recipes)
    {
        $this->recipes[] = $recipes;

        return $this;
    }

    /**
     * Remove recipes
     *
     * @param \Acme\DemoBundle\Entity\Recipe $recipes
     */
    public function removeRecipe(\Acme\DemoBundle\Entity\Recipe $recipes)
    {
        $this->recipes->removeElement($recipes);
    }
}
