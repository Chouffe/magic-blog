<?php

namespace Chouffe\MagicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('Cover', 'entity', array(
                'class' => 'ChouffeMagicBundle:Photo',
                'property' => 'title',
                'empty_value' => 'Choose an option',
                'required' => false,
                )) 
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Chouffe\MagicBundle\Entity\Album'
        ));
    }

    public function getName()
    {
        return 'chouffe_magicbundle_albumtype';
    }
}

