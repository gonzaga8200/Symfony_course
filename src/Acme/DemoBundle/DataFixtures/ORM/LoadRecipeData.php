<?php

// src/Acme/HelloBundle/DataFixtures/ORM/LoadUserData.php

namespace Acme\HelloBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\DemoBundle\Entity\Recipe;

class LoadRecipeData extends AbstractFixture implements OrderedFixtureInterface {

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $recipe = new Recipe($this->getReference('karlos-author'),'Pollo con Fundamento','Receta rica rica','medio');
        $manager->persist($recipe);
        $manager->flush();
    }
    public function getOrder()
    {
        return 3;
    }

}

?>
