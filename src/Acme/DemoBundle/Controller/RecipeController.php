<?php

// src/Acme/HelloBundle/Controller/HelloController.php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\DemoBundle\Entity\Recipe;
use Acme\DemoBundle\Entity\Author;
use Acme\DemoBundle\Form\RecipeType;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Security\Acl\Exception\Exception;
use Acme\DemoBundle\Event\RecipeEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Acme\DemoBundle\EventListener\RecipesListener;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Doctrine\Common\Persistence\ObjectManager;

class RecipeController extends Controller {
    
    /**
     * @Template()
     */
    public function testTransAction() {
        //$request->setLocale('fr_FR');
        //$translated = $this->get('translator')->trans('Symfony is great');
        return array ('count'=>0);
    }
    
    public function testTransVarAction(Request $request, $name) {
        $request->setLocale('fr_FR');
        $translated = $this->get('translator')->trans('Hello %name%',array('%name%'=>$name));
        return new Response($translated);
    }
    
    public function testTransPluriAction() {
        //$request->setLocale('fr_FR');
        $translated = $this->get('translator')->transChoice('Symfony is great | Symfony %count% great',array('%count%'=>200));
        return new Response($translated);
    }

    /**
     * @Template()
     */
    public function indexAction() {
        $recipes = $this->getDoctrine()->getRepository('AcmeDemoBundle:Recipe')->findAll();
        $logger = $this->get('logger');
        $logger->info('ola k ase');
        $logger->error('An error occurred');
        return array(
            'recipes' => $recipes,
        );
    }

    /*     * **** CREATE ************************* */

    /**
     * @Template
     */
    public function newAction() {
        return array(
            'form' => $this->createCreateForm(new Recipe())->createView()
        );
    }

    private function createCreateForm($entity) {
        return $this->createForm(new RecipeType(), $entity, array(
                    'action' => $this->generateUrl('create_recipe'),
                    'method' => 'POST'
                ));
    }

    public function createAction(Request $request) {
        $recipe = new Recipe();
        $form = $this->createCreateForm($recipe);
        $form->handleRequest($request);
        if ($form->isValid()) {
            //$this->get("recipe.create")->create($recipe)*//
            $dispatcher = new EventDispatcher();
            $listener = new RecipesListener();
            $dispatcher->addListener('recipes.creates', array($listener, 'onRecipeCreate'));
            //$event = new RecipeEvent($recipe);
            //die();
            //$this->get('event_dispatcher')->dispatch('recipe.create', new EventDispatcher);
            $event = new RecipeEvent($recipe);  
            $dispatcher->dispatch('recipes.creates', $event);
            return $this->redirect($this->generateUrl('recipe_name'));
        }
        throw new Exception();
    }

    /*     * ****** END CREATE ********************* */
    /*     * ****** EDIT *************************** */

    /**
     * @param $id
     * @return array
     * @Template()
     * @throws \Doctrine\ORM\EntityNotFoundException@
     */
    public function editAction($id) {
        $recipe = $this->getDoctrine()->getRepository('AcmeDemoBundle:Recipe')->find($id);
        if (!$recipe)
            throw new EntityNotFoundException();
        $edit_form = $this->createEditForm($recipe);
        $delete_form = $this->createDeleteForm($recipe->getId());
        return array(
            'edit_form' => $edit_form->createView(),
            'delete_form' => $delete_form->createView()
        );
    }

    private function createEditForm($entity) {
        return $this->createForm(new RecipeType(), $entity, array(
                    'action' => $this->generateUrl('update_recipe', array('id' => $entity->getId())),
                    'method' => 'PUT'
                ));
    }

    public function updateAction(Request $request, $id) {
        $recipe = $this->getDoctrine()->getRepository('AcmeDemoBundle:Recipe')->find($id);
        $form = $this->createEditForm($recipe);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);
            $em->flush();
            return $this->redirect($this->generateUrl('recipe_name'));
        }
        $edit_form = $this->createEditForm($recipe);
        $edit_form->handleRequest($request);
        //$delete_form = $this->createDeleteForm($author->getId());
        return $this->render('AcmeDemoBundle:Recipe:edit', array(
                    'edit_form' => $edit_form->createView(),
                        //'delete_form' => $delete_form->createView()
                ));
    }

    /*     * ********** END EDIT ********************************* */
    /*     * ********** DELETE *********************************** */

    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('delete_recipe', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm();
    }

    public function deleteAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $recipe = $this->getDoctrine()->getRepository('AcmeDemoBundle:Recipe')->find($id);
        if ($recipe) {
            $em->remove($recipe);
            $em->flush();
            return $this->redirect($this->generateUrl('recipe_name'));
        }
        throw new EntityNotFoundException();
    }

    // ******************* END DELETE ****************************/
    //*********** LAST RECIPES ************************************ //
    /**
     * @Template()
     */
    public function lastRecipesAction() {
        $date = new \DateTime('-10 Days');
        return array('recipes' => $this->get('recipes.last')->findForm($date));
    }

    // ********** OLD METHODS ******************** //

    /* public function createAction($name) {
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
    /* public function create2Action($name, $surname, $recipe_name, $description, $difficulty, $ingredient_r) {
      //$em = $this->getDoctrine()->getEntityManager();
      $author = new Author($name, $surname);
      //$em->persist($author);

      $ingredient = new Ingredient($ingredient_r);
      //$em->persist($ingredient);

      $recipe = new Recipe($author, $recipe_name, $description, $difficulty);
      $recipe->add($ingredient);

      //$em->persist($recipe);

      $this->persistAndFlush($recipe);

      return $this->render("AcmeDemoBundle:Recipe:create.html.twig", array('recipe' => $recipe, 'author' => $author));
      }

      private function persistAndFlush(Recipe $recipe) {
      $em = $this->getDoctrine()->getEntityManager();
      $em->persist($recipe);
      $em->flush();
      }

      /**
     * @Template()
     */
    /* public function showAction($id) {
      $repository = $this->getDoctrine()->getRepository('AcmeDemoBundle:Recipe');
      $recipe = $repository->find($id);
      //return new Response($recipe->getDescription());
      return $this->render("AcmeDemoBundle:Recipe:show.html.twig", array('recipe' => $recipe));

      //return array('description' => $recipe->getDescription());
      }

      /**
     * @Template("AcmeDemoBundle:Recipe:show.html.twig")
     */
    /* public function showNameAction($name) {
      $repository = $this->getDoctrine()->getRepository('AcmeDemoBundle:Recipe');
      $recipe = $repository->findOneByName($name);
      return $this->render("AcmeDemoBundle:Recipe:show.html.twig", array('recipe' => $recipe));
      }

      /**
     * @Template("AcmeDemoBundle:Recipe:show_all.html.twig")
     */
    /* public function showAllAction() {
      $repository = $this->getDoctrine()->getRepository('AcmeDemoBundle:Recipe');
      $recipe = $repository->findAll();
      echo "<pre>";
      echo "</pre>";
      return $this->render("AcmeDemoBundle:Recipe:show_all.html.twig", array('recipe' => $recipe));
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

      public function showAuthorsAction() {
      $em = $this->getDoctrine()->getManager();
      $query = $em->createQuery('SELECT a FROM AcmeDemoBundle:Author a JOIN a.recipes r ORDER BY a.surname DESC ');
      $hardcore_authors = $query->getArrayResult();
      print_r($hardcore_authors);
      return new Response("");
      }

      public function edit2Action($name, $new_name) {
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
      } */
    /**
     * @Template("AcmeDemoBundle:Recipe:create2.html.twig")
     */
    /* public function createByFormAction(Request $request) {
      $recipe = new Recipe();
      $form = $this->createForm(new RecipeType, $recipe);
      $form->handleRequest($request);
      //$validator = $this->get('validator');
      //$errors = $validator->validate($author);

      if ($form->isValid()) {
      echo "VALIDO";
      $em = $this->getDoctrine()->getManager();
      $em->persist($recipe);
      $em->flush();
      return $this->render("AcmeDemoBundle:Recipe:success.html.twig", array(''));
      //return $this->redirect($this->generateUrl('task_success'));
      }
      return array('form' => $form->createView());
      } */
}

?>
