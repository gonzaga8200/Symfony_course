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

}
