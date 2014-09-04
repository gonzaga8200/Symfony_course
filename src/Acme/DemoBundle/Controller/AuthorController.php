<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Acme\DemoBundle\Entity\Author;

use Acme\DemoBundle\Form\AuthorType;

class AuthorController extends Controller
{
    /**
     * @Template("AcmeDemoBundle:Author:create.html.twig")
     */
    public function createAction(Request $request)
    {
        $author = new Author();
        $form = $this->createFormBuilder($author)
                ->add('name', 'text')
                ->add("surname",'text')
                ->add('save','submit')
                ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()){
            echo "VALIDO";
            $em = $this->getDoctrine()->getManager();
            $em->persist($author);
            $em->flush();
            return $this->redirect($this->generateUrl('recipe_show',array('id'=>$author->getId())));
            //return $this->redirect($this->generateUrl('task_success'));
        }
        return array('form'=>$form->createView());  
    }
    /**
     * @Template("AcmeDemoBundle:Author:create.html.twig")
     */
    public function create2Action(Request $request)
    {
        $author = new Author();
        $form = $this->createForm(new AuthorType, $author);       
        $form->handleRequest($request);
        //$validator = $this->get('validator');
        //$errors = $validator->validate($author);
        
        if ($form->isValid()){
            echo "VALIDO";
            $em = $this->getDoctrine()->getManager();
            $em->persist($author);
            $em->flush();
            return $this->render("AcmeDemoBundle:Author:success.html.twig",array(''));
            //return $this->redirect($this->generateUrl('task_success'));
        }
        return array('form'=>$form->createView());  
    }

}
