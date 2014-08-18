<?php

// src/Acme/HelloBundle/Controller/HelloController.php

namespace Acme\DemoBundle\Controller;
use Acme\DemoBundle\Entity\Recipe;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeController extends Controller {

    public function indexAction($name) {
        return new Response('<html><body>Hello ' . $name . '!</body></html>');
    }
    
    public function createAction($name){
        $recipe = new Recipe();
        $recipe->setName($name);
        $recipe->setDifficulty('Dificil');
        $recipe->setDescription('Muy salado');
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($recipe);
        $em->flush();
        
        return new Response('Receta creada con el siguiente ID'.$recipe->getId());
    }
    public function create2Action (){
        $em = $this->getDoctrine()->getEntityManager();
        $author = new Author('Ferra Adria');
        $em->persist($author);
        
        $ingredient = new Ingredient('pollo');
        $em->persist($ingredient);
        
        $recipe = new Recipe($author,'pollo-al-chilindron','cojonuda receta','facil');
        $recipe->add($ingredient);
        
        $em->persist($recipe);
        
        $em->flush();
        
        return $this->redirect($this->generateUrl('recipes_show'),array('id'=>$recipe->getId()));
        
    }
    
    public function showAction ($id){
        $repository = $this->getDoctrine()->getRepository('AcmeDemoBundle:Recipe');
        $recipe = $repository->find($id);
        return new Response($recipe->getDescription());
    }
	public function showNameAction ($name){
        $repository = $this->getDoctrine()->getRepository('AcmeDemoBundle:Recipe');
        $recipe = $repository->findOneByName($name);
        return new Response($recipe->getDescription());
    }
    public function showAllAction (){
        $repository = $this->getDoctrine()->getRepository('AcmeDemoBundle:Recipe');
        $recipe = $repository->findAll();
        echo "<pre>";
        print_r($recipe);
        echo "</pre>";
        return new Response("test");
    }
    public function editAction($name,$new_name){
        $repository = $this->getDoctrine()->getRepository('AcmeDemoBundle:Recipe');
        $recipe = $repository->findOneByName($name);
        $recipe->setName('Bacalao con Tomate');
        $this->getDoctrine()->getManager()->flush();
        return new Response($recipe->getName());
    }
    public function removeAction ($name){
        $repository = $this->getDoctrine()->getRepository('AcmeDemoBundle:Recipe');
        $recipe = $repository->findOneByName($name);
        $em = $this->getDoctrine()->getManager();
        $em->remove($recipe);
        $em->flush();
        return new Response("You have deleted ".$name);
    }

}

?>
