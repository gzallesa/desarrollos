<?php

namespace Support\SupportBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocmanUserType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('username')
            ->add('password')
            ->add('movil')
            ->add('interno')
            ->add('ci')
            ->add('type')
            ->add('telefono')
            ->add('direccion')
            ->add('telefref')
            ->add('numseguro')
            ->add('cargo')
            ->add('fechanac')
            ->add('ip')
            ->add('dependeDe')
            ->add('foto')
            ->add('soporte')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Support\SupportBundle\Entity\DocmanUser'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'support_supportbundle_docmanuser';
    }
}
