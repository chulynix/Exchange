<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/17/15
 * Time: 4:04 PM
 */

namespace Admin\MembersBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class UserAccountFormType
 * @package Admin\MembersBundle\Form\Type
 */
class BtcWalletFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('sum', 'money', array(
            'constraints'   => array(new NotBlank()),
            'scale'         => 8,
            'label'         => " ",
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WalletBundle\Entity\BtcWallet',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'btc_wallet';
    }
}
