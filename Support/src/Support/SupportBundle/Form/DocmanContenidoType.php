<?php

namespace Support\SupportBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocmanContenidoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('descripcion')
            ->add('url')
            ->add('tipo', 'choice', array(
                    'choices' => array('6'=>'Resolucion','7'=>'Formulario'),
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Support\SupportBundle\Entity\DocmanContenido'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'support_supportbundle_docmancontenido';
    }
}
