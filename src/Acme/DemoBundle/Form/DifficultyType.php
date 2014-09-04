<?php

namespace Acme\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Acme\DemoBundle\Entity\Difficulties;

class DifficultyType extends AbstractType
{   
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => Difficulties::toArray()
        ));
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'choice';
    }
    
    public function getName()
    {
        return 'difficulty';
    }
}
