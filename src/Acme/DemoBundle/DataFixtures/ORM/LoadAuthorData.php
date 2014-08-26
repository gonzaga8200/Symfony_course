<?php

// src/Acme/HelloBundle/DataFixtures/ORM/LoadUserData.php

namespace Acme\DemoBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
//use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\DemoBundle\Entity\Author;


class LoadAuthorData extends AbstractFixture implements OrderedFixtureInterface {

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $author = new Author('Karlos','Arguinyano');
        $this->addReference('karlos-author', $author);
        //$author->setName('Karlos');
        //$author->setSurname('Arguiñano');

        $manager->persist($author);
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }

}

?>
