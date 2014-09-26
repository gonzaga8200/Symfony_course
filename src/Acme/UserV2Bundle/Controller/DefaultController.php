<?php

namespace Acme\UserV2Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Acme\UserV2Bundle\Entity\User;
use Acme\UserV2Bundle\Entity\Role;
use Acme\UserV2Bundle\Form\UserType;

class DefaultController extends Controller {

    public function indexAction($name) {
        return $this->render('AcmeUserV2Bundle:Default:index.html.twig', array('name' => $name));
    }

    /**
     * @Route("/new/registration/", name="new_user")
     * @Template()
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

    /**
     * @Route("/create_user", name="create_user")
     */
    public function createAction(Request $request) {
        $user = new User();
        $repository = $this->getDoctrine()->getRepository('AcmeUserV2Bundle:Role');
        $role = $repository->findOneByName("User");
        $user->addRole($role);
        $form = $this->createCreateForm($user);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirect($this->generateUrl('new_user'));
        }
        throw new Exception();
    }
    /**
     * @Route("/admin/show/", name="show_users")
     * @Template()
     */
    public function showAction() {
        $users = $this->getDoctrine()->getRepository('AcmeUserV2Bundle:User')->findAll();
        return array ('users'=>$users);
    }
    /**
     * @Route("/admin/setUser/{id}", name="set_user")
     * @Template()
     */
    public function setUserAction($id) {
        $user = $this->getDoctrine()->getRepository('AcmeUserV2Bundle:User')->find($id);
        $user->setIsActive(false);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return array ();
    }
    /**
     * @Route("/admin/addRole/{id}", name="add_role")
     * @Template()
     */
    public function addRoleAction($id) {
        $repository = $this->getDoctrine()->getRepository('AcmeUserV2Bundle:Role');
        $role = $repository->findOneByName("Admin");
        $user = $this->getDoctrine()->getRepository('AcmeUserV2Bundle:User')->find($id);
        $user->addRole($role);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return array ();
    }

}
