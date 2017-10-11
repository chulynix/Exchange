<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 5/18/16
 * Time: 11:37 AM
 */

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ProfileFormType
 * @package UserBundle\Form\Type
 */
class ProfileFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $builder->remove('username');
//        $builder->remove('email');
        $builder
            ->add('name', TextType::class, array(
                'constraints' => array(new NotBlank()),
            ))
            ->add('surname', TextType::class, array(
                'constraints' => array(new NotBlank()),
            ))
            ->add('country', CountryType::class, array(
                'constraints' => array(new NotBlank()),
            ))
            ->add('city', TextType::class, array(
                'constraints' => array(new NotBlank()),
            ))
            ->add('phone', TextType::class, array(
                'constraints' => array(new NotBlank()),
            ))
            ->add('zipCode', TextType::class, array(
                'constraints' => array(new NotBlank()),
            ));
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'fos_user_profile';
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'user_profile';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
