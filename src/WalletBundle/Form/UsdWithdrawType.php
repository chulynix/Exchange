<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/22/16
 * Time: 10:41 AM
 */

namespace WalletBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WalletBundle\Entity\UsdWithdraw;

/**
 * Class UsdWithdrawType
 * @package WalletBundle\Form
 */
class UsdWithdrawType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bankName', TextType::class, array(
                'required'  => false,
            ))
            ->add('bankSwiftCode', TextType::class, array(
                'required'  => false,
            ))
            ->add('bankStreet', TextType::class, array(
                'required'  => false,
            ))
            ->add('bankCity', TextType::class, array(
                'required'  => false,
            ))
            ->add('bankCountry', TextType::class, array(
                'required'  => false,
            ))
            ->add('bankProvinceState', TextType::class, array(
                'required'  => false,
                'label'     => 'office.accounts.bank_province_state',
            ))
            ->add('bankZipPostalCode', TextType::class, array(
                'required'  => false,
                'label'     => 'office.accounts.bank_zip_postal_code',
            ))
            ->add('bankAccountNumber', TextType::class, array(
                'required'  => false,
            ))
            ->add('currency', TextType::class, array(
                'required'  => false,
            ))
            ->add('iban', TextType::class, array(
                'required'  => false,
            ))
            ->add('bankAbaRoutingCode', TextType::class, array(
                'required'  => false,
                'label'     => 'office.accounts.bank_aba_routing_code',
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => UsdWithdraw::class,
        ));
    }
}
