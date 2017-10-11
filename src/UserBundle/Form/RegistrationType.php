<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/16/16
 * Time: 10:12 AM
 */

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class RegistrationType
 * @package UserBundle\Form
 */
class RegistrationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label'                 => 'home.register.name',
                'translation_domain'    => 'messages',
                'constraints'           => array(new NotBlank()),
            ))
            ->add('surname', TextType::class, array(
                'label'                 => 'home.register.surname',
                'translation_domain'    => 'messages',
                'constraints'           => array(new NotBlank()),
            ));
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
