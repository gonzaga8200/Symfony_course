<?php

// src/Acme/HelloBundle/Controller/HelloController.php

namespace Acme\DemoBundle\Controller;

use Acme\DemoBundle\Entity\Recipe;
use Acme\DemoBundle\Entity\Author;
use Acme\DemoBundle\Entity\Ingredient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeController extends Controller {

    public function indexAction($name) {
        return new Response('<html><body>Hello ' . $name . '!</body></html>');
    }

    public function createAction($name) {
        $recipe = new Recipe();
        $recipe->setName($name);
        $recipe->setDifficulty('Dificil');
        $recipe->setDescription('Muy salado');

        $em = $this->getDoctrine()->getManager();
        $em->persist($recipe);
        $em->flush();

        return new Response('Receta creada con el siguiente ID' . $recipe->getId());
    }

    public function create2Action() {
        //$em = $this->getDoctrine()->getEntityManager();
        $author = new Author('Ferra', 'Adria');
        //$em->persist($author);

        $ingredient = new Ingredient('pollo');
        //$em->persist($ingredient);

        $recipe = new Recipe($author, 'pollo-al-chilindron', 'cojonuda receta', 'facil');
        $recipe->add($ingredient);

        //$em->persist($recipe);

        $this->persistAndFlush($recipe);

        return $this->redirect($this->generateUrl('recipe_show', array('id' => $recipe->getId())));
    }

    private function persistAndFlush(Recipe $recipe) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($recipe);
        $em->flush();
    }

    public function showAction($id) {
        $repository = $this->getDoctrine()->getRepository('AcmeDemoBundle:Recipe');
        $recipe = $repository->find($id);
        return new Response($recipe->getDescription());
    }

    public function showNameAction($name) {
        $repository = $this->getDoctrine()->getRepository('AcmeDemoBundle:Recipe');
        $recipe = $repository->findOneByName($name);
        return new Response($recipe->getDescription());
    }

    public function showAllAction() {
        $repository = $this->getDoctrine()->getRepository('AcmeDemoBundle:Recipe');
        $recipe = $repository->findAll();
        echo "<pre>";
        echo "</pre>";
        return new Response("test");
    }

    public function showRecipesAuthorAction($id) {
        $repository = $this->getDoctrine()->getRepository('AcmeDemoBundle:Author');
        $author = $repository->find($id);
        $recipes = $author->getRecipes();
        echo "<pre>";
        print_r($recipes->count());
        echo "</pre>";
        return new Response($author->getName());
        
    }
    
    public function showAuthorsAction (){
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT a FROM AcmeDemoBundle:Author a JOIN a.recipes r ORDER BY a.surname DESC ');
        $hardcore_authors = $query->getArrayResult();
        print_r($hardcore_authors);
        return new Response("");
    }

    public function editAction($name, $new_name) {
        $repository = $this->getDoctrine()->getRepository('AcmeDemoBundle:Recipe');
        $recipe = $repository->findOneByName($name);
        $recipe->setName('Bacalao con Tomate');
        $this->getDoctrine()->getManager()->flush();
        return new Response($recipe->getName());
    }

    public function removeAction($name) {
        $repository = $this->getDoctrine()->getRepository('AcmeDemoBundle:Recipe');
        $recipe = $repository->findOneByName($name);
        $em = $this->getDoctrine()->getManager();
        $em->remove($recipe);
        $em->flush();
        return new Response("You have deleted " . $name);
    }

}

?>
