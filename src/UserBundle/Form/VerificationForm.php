<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/8/16
 * Time: 3:32 PM
 */

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\NotBlank;
use UserBundle\Entity\Verification;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * Class VerificationForm
 * @package UserBundle\Form
 */
class VerificationForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('passportFile', VichImageType::class, array(
                'allow_delete'  => false, // not mandatory, default is true
                'download_link' => true, // not mandatory, default is true
                'label'         => "office.verification.passport_photo",
                'constraints'   => array(new NotBlank()),
            ))
            ->add('servicesFile', VichImageType::class, array(
                'allow_delete'  => false, // not mandatory, default is true
                'download_link' => true, // not mandatory, default is true
                'label'         => "office.verification.services_photo",
                'constraints'   => array(new NotBlank()),
            ))
            ->add('documentFile', VichImageType::class, array(
                'allow_delete'  => false, // not mandatory, default is true
                'download_link' => true, // not mandatory, default is true
                'label'         => "office.verification.document_photo",
                'constraints'   => array(new NotBlank()),
            ))
            ->add('skype', TextType::class, array(
                'label'         => "office.verification.skype",
                'constraints'   => array(new NotBlank()),
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Verification::class,
        ));
    }
}
