<?php

namespace Acme\DemoBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;

use Acme\DemoBundle\Entity\Author;

use Acme\DemoBundle\Form\AuthorType;
use Symfony\Component\Security\Acl\Exception\Exception;

class AuthorController extends Controller
{
    /**
     * @Template("AcmeDemoBundle:Author:create.html.twig")
     */
//    public function createAction(Request $request)
//    {
//        $author = new Author();
//        $form = $this->createFormBuilder($author)
//                ->add('name', 'text')
//                ->add("surname",'text')
//                ->add('save','submit')
//                ->getForm();
//
//        $form->handleRequest($request);
//
//        if ($form->isValid()){
//            echo "VALIDO";
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($author);
//            $em->flush();
//            return $this->redirect($this->generateUrl('author_show',array('id'=>$author->getId())));
//            //return $this->redirect($this->generateUrl('task_success'));
//        }
//        return array('form'=>$form->createView());
//    }
    /**
     * @Template("AcmeDemoBundle:Author:create.html.twig")
     */
//    public function create2Action(Request $request)
//    {
//        $author = new Author();
//        $form = $this->createForm(new AuthorType, $author);
//        $form->handleRequest($request);
//        //$validator = $this->get('validator');
//        //$errors = $validator->validate($author);
//
//        if ($form->isValid()){
//            echo "VALIDO";
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($author);
//            $em->flush();
//            return $this->render("AcmeDemoBundle:Author:success.html.twig",array(''));
//            //return $this->redirect($this->generateUrl('task_success'));
//        }
//        return array('form'=>$form->createView());
//    }

    //Oscar:
    //Metodo para mostrar una lista de todos los author
    /**
     * @Template()
     */
    public function indexAction() {
        $authors = $this->getDoctrine()->getRepository('AcmeDemoBundle:Author')->findAll();
        return array(
            'authors' => $authors,
        );
    }

    //Oscar:
    //Metodo para mostrar el formulario de creacion de un author
    /**
     * @Template
     */
    public function newAction() {
        return array(
            'form' => $this->createCreateForm(new Author())->createView()
        );
    }

    //Oscar:
    //Metodo para crear el formulario de nuevo author
    private function createCreateForm($entity) {
        /*
         * Si ya tienes definido el formulario en AuthorType, no tiene sentido volver a definirlo
         * con $this->createFormBuilder()
         */
        return $this->createForm(new AuthorType(), $entity, array(
            'action' => $this->generateUrl('create_author'),
            'method' => 'POST'
        ))->add('submit', 'submit', array('label'=>'Save'));
    }

    //Oscar:
    //Metodo para crear el formulario de editar author
    private function createEditForm($entity) {
        return $this->createForm(new AuthorType(), $entity, array(
            'action' => $this->generateUrl('update_author', array('id'=>$entity->getId())),
            'method' => 'PUT'
        ))->add('submit', 'submit', array('label'=>'Save'));
    }

    //Oscar:
    //Metodo para elimiar el author
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('delete_author', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    //Oscar:
    //Metodo para crear el formulario de editar un author
    /**
     * @param $id
     * @return array
     * @Template()
     * @throws \Doctrine\ORM\EntityNotFoundException@
     */
    public function editAction($id) {
        $author = $this->getDoctrine()->getRepository('AcmeDemoBundle:Author')->find($id);
        if(!$author)
            throw new EntityNotFoundException();
        $edit_form = $this->createEditForm($author);
        $delete_form = $this->createDeleteForm($author->getId());
        return array(
            'edit_form' => $edit_form->createView(),
            'delete_form' => $delete_form->createView()
        );
    }

     //Oscar:
     //Metodo para mostrar el author y sus recipes
    /**
     * @Template()
     */
    public function showAction($id) {
        $author = $this->getDoctrine()->getRepository('AcmeDemoBundle:Author')->find($id);
        if($author) // Si el author existe nos lleva a la vista
            return array(
                'author' => $author,
                'delete_form' => $this->createDeleteForm($author->getId())->createView()
            );
        return new EntityNotFoundException(); // Si no existe el author devolvemos un error
    }

    //Oscar:
    //Metodo para crear un author
    public function createAction(Request $request) {
        $author = new Author();
        $form = $this->createCreateForm($author);
        $form->handleRequest($request);
        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($author);
            $em->flush();
            return $this->redirect($this->generateUrl('show_author', array('id'=>$author->getId())));
        }
        throw new Exception();
    }

    //Oscar:
    //Metodo para actualizar un author
    public function updateAction(Request $request, $id) {
        $author = $this->getDoctrine()->getRepository('AcmeDemoBundle:Author')->find($id);
        $form = $this->createEditForm($author);
        $form->handleRequest($request);
        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($author);
            $em->flush();
            return $this->redirect($this->generateUrl('show_author', array('id'=>$author->getId())));
        }
        $edit_form = $this->createEditForm($author);
        $edit_form->handleRequest($request);
        $delete_form = $this->createDeleteForm($author->getId());
        return $this->render('AcmeDemoBundle:Author:edit', array(
            'edit_form' => $edit_form->createView(),
            'delete_form' => $delete_form->createView()
        ));
    }

    //Oscar:
    //Metodo para eliminar un author
    public function deleteAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $author = $this->getDoctrine()->getRepository('AcmeDemoBundle:Author')->find($id);
        if($author) {
            $em->remove($author);
            $em->flush();
            return $this->redirect($this->generateUrl('index_author'));
        }
        throw new EntityNotFoundException();
    }

}
