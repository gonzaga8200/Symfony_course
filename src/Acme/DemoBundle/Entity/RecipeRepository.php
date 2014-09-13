<?php

namespace Acme\DemoBundle\Entity;

use Doctrine\ORM\EntityRepository;

class RecipeRepository extends EntityRepository {

    public function findPublishedAfter(\DateTime $from) {
        //echo 'SELECT p.name FROM AcmeDemoBundle:Recipe p where '.$from->format('Y-m-d').' < p.date ORDER BY p.name ASC';
        //die();
        /*return $this->getEntityManager()
            ->createQuery(
                'SELECT p.name FROM AcmeDemoBundle:Recipe p where p.date > '.$from->format('Y-m-d H:i:s').'  ORDER BY p.name ASC'
            )
            ->getResult();*/
        return $this->createQueryBuilder('p')
            ->where('p.date >= :ts')
                ->setParameter('ts', $from)
            ->getQuery()->getResult();
    }

}

?>
