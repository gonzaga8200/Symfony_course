<?php

namespace Acme\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Acme\DemoBundle\Entity\Difficulties;
use Acme\DemoBundle\Entity\Author;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', 'text')
                ->add('difficulty', new DifficultyType)
                ->add('description', 'text')
                ->add('author', new AuthorType)
                ->add('date', 'datetime')
                //->add('author', 'choice', array('choices' => $authors))
                ->add('save', 'submit')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\DemoBundle\Entity\Recipe',
            'cascade_validation' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'acme_demobundle_recipe';
    }

}
