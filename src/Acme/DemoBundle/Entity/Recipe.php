<?php

namespace Acme\DemoBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

class Recipe {

    protected $author;
    protected $ingredient;
    private $id;
    private $name;
    private $difficulty;
    private $description;
    private $date;

    /**
     * Get id
     *
     * @return integer 
     */
    /*public function __construct(Author $author,$name,$description,$difficulty) {
        $this->author = $author;
        $this->name = $name;
        $this->description = $description;
        $this->difficulty = $difficulty;
        $this->ingredient = new ArrayCollection();
        
        
    }*/
    public function add (Ingredient $ingredient){
        $this->ingredient[] = $ingredient;
    }
    public function getId() {
        return $this->id;
    }
    
    public function getAuthor (){
        return $this->author;
    }
    
    public function setAuthor ($author){
        $this->author = $author;
        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Recipe
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set difficulty
     *
     * @param string $difficulty
     * @return Recipe
     */
    public function setDifficulty($difficulty) {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * Get difficulty
     *
     * @return string 
     */
    public function getDifficulty() {
        return $this->difficulty;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Recipe
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ingredient = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ingredient
     *
     * @param \Acme\DemoBundle\Entity\Ingredient $ingredient
     * @return Recipe
     */
    public function addIngredient(\Acme\DemoBundle\Entity\Ingredient $ingredient)
    {
        $this->ingredient[] = $ingredient;

        return $this;
    }

    /**
     * Remove ingredient
     *
     * @param \Acme\DemoBundle\Entity\Ingredient $ingredient
     */
    public function removeIngredient(\Acme\DemoBundle\Entity\Ingredient $ingredient)
    {
        $this->ingredient->removeElement($ingredient);
    }

    /**
     * Get ingredient
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Recipe
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }
}
