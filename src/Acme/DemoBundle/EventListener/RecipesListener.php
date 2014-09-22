<?php

namespace Acme\DemoBundle\EventListener;
use Acme\DemoBundle\Entity\Recipe;
use Acme\DemoBundle\Event\RecipeEvent;
class RecipesListener {
    public function __construct() {
        ;
    }
    public function onRecipeCreate (RecipeEvent $event){
        //die('paso por aqui');
        //$recipe = $event->getRecipe();
        //$logger = $this->get('logger');
        //$logger->info('Se creo correctamente la receta');
        //$logger->error('An error occurred');
        
    }
}

?>
