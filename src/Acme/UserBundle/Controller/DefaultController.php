<?php

namespace Acme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Acme\UserBundle\Entity\User;
use Acme\UserBundle\Form\UserType;

/**
 * @Route("/user/")
 */
class DefaultController extends Controller {

    public function indexAction($name) {
        return $this->render('AcmeUserBundle:Default:index.html.twig', array('name' => $name));
    }

    /**
     * @Template
     */
    public function newAction() {
        return array(
            'form' => $this->createCreateForm(new User())->createView()
        );
    }

    private function createCreateForm($entity) {
        return $this->createForm(new UserType(), $entity, array(
                    'action' => $this->generateUrl('create_user'),
                    'method' => 'POST'
                ));
    }

    public function createAction(Request $request) {
        $user = new User();
        $form = $this->createCreateForm($user);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirect($this->generateUrl('acme_user_homepage',array('name'=>'Gonzalo')));
        }
        throw new Exception();
    }

}
