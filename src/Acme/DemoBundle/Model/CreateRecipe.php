<?php

namespace Acme\DemoBundle\Model;
//namespace Acme\DemoBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Doctrine\ORM\EntityManager;

use Doctrine\Common\Persistence\ObjectManager;

use Acme\DemoBundle\Entity\Recipe;


class CreateRecipe  {
    /**
     * @var ObjectManager
     */
    private $om;
    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om) {
        $this->om = $om;
    }
    public function create (Recipe $recipe){
        $this->om->persist($recipe);
        $this->om->flush();
    }
}

?>
