<?php

namespace Acme\DemoBundle\Model;
//namespace Acme\DemoBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Doctrine\ORM\EntityManager;

use Doctrine\Common\Persistence\ObjectManager;

use Acme\DemoBundle\Entity\Recipe;


class LastRecipes  {
    /**
     * @var ObjectManager
     */
    private $repository;
    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om) {
        $this->repository = $om->getRepository("AcmeDemoBundle:Recipe");
    }
    public function findForm (\DateTime $fromDate){
        return $this->repository->findPublishedAfter($fromDate);
    }
}

?>
