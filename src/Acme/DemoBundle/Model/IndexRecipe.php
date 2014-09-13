<?php

namespace \Acme\DemoBundle\Model;

use Doctrine\Common\Persistence\ObjectManager;
class IndexRecipe {
    public function __construct() {
        $recipes = $this->getDoctrine()->getRepository('AcmeDemoBundle:Recipe')->findAll();
    }
}

?>
