<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/17/15
 * Time: 3:39 PM
 */

namespace Admin\MembersBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class UserWalletFormType
 * @package Admin\MemberBundle\Form\Type
 */
class UsdWalletFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('sum', MoneyType::class, array(
            'constraints'   => array(new NotBlank()),
            'scale'         => 2,
            'label'         => " ",
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WalletBundle\Entity\UsdWallet',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'usd_wallet';
    }
}
