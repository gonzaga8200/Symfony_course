<?php

// src/Acme/HelloBundle/Controller/HelloController.php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Acme\DemoBundle\Entity\Recipe;

use Acme\DemoBundle\Entity\Author;

use Acme\DemoBundle\Form\RecipeType;

class RecipeController extends Controller {
    
    /**
     * @Template("AcmeDemoBundle:Recipe:recipe.html.twig")
     */
    public function indexAction($name) {
        return array('name' => $name);
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

    /**
     * @Template("AcmeDemoBundle:Recipe:create.html.twig")
     */
    public function create2Action($name,$surname,$recipe_name,$description,$difficulty,$ingredient_r) {
        //$em = $this->getDoctrine()->getEntityManager();
        $author = new Author($name, $surname);
        //$em->persist($author);

        $ingredient = new Ingredient($ingredient_r);
        //$em->persist($ingredient);

        $recipe = new Recipe($author, $recipe_name,$description,$difficulty);
        $recipe->add($ingredient);

        //$em->persist($recipe);

        $this->persistAndFlush($recipe);

        return $this->render("AcmeDemoBundle:Recipe:create.html.twig",array('recipe'=>$recipe,'author'=>$author));
    }

    private function persistAndFlush(Recipe $recipe) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($recipe);
        $em->flush();
    }
    
    /**
     * @Template()
     */
    public function showAction($id) {
        $repository = $this->getDoctrine()->getRepository('AcmeDemoBundle:Recipe');
        $recipe = $repository->find($id);
        //return new Response($recipe->getDescription());
        return $this->render("AcmeDemoBundle:Recipe:show.html.twig",array('recipe'=>$recipe));
        
        //return array('description' => $recipe->getDescription());
    }
    
    /**
     * @Template("AcmeDemoBundle:Recipe:show.html.twig")
     */
    public function showNameAction($name) {
        $repository = $this->getDoctrine()->getRepository('AcmeDemoBundle:Recipe');
        $recipe = $repository->findOneByName($name);
        return $this->render("AcmeDemoBundle:Recipe:show.html.twig",array('recipe'=>$recipe));
    }

    
    /**
     * @Template("AcmeDemoBundle:Recipe:show_all.html.twig")
     */
    public function showAllAction() {
        $repository = $this->getDoctrine()->getRepository('AcmeDemoBundle:Recipe');
        $recipe = $repository->findAll();
        echo "<pre>";
        echo "</pre>";
        return $this->render("AcmeDemoBundle:Recipe:show_all.html.twig",array('recipe'=>$recipe));
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
    
    /**
     * @Template("AcmeDemoBundle:Recipe:create2.html.twig")
     */
    public function createByFormAction(Request $request)
    {
        $recipe = new Recipe();
        $form = $this->createForm(new RecipeType, $recipe);       
        $form->handleRequest($request);
        //$validator = $this->get('validator');
        //$errors = $validator->validate($author);
        
        if ($form->isValid()){
            echo "VALIDO";
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);
            $em->flush();
            return $this->render("AcmeDemoBundle:Recipe:success.html.twig",array(''));
            //return $this->redirect($this->generateUrl('task_success'));
        }
        return array('form'=>$form->createView());  
    }

}

?>
