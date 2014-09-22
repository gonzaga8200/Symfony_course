<?php

namespace Acme\DemoBundle\Event;
use Acme\DemoBundle\Entity\Recipe;
use Doctrine\ORM\EntityManager;

//use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\EventDispatcher\Event;
class RecipeEvent extends Event {
    private $recipe;
    
    public function __construct(Recipe $recipe) {
        $om = new \Doctrine\Common\Persistence\ObjectManager;
        $this->recipe = $recipe;
        $om->persist($recipe);
        $om->flush();
    }
    public function getRecipe (){
        
    }
}

?>
