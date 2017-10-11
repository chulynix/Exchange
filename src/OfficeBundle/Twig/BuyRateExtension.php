<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/2/16
 * Time: 3:25 PM
 */

namespace OfficeBundle\Twig;

use Doctrine\ORM\EntityManager;

/**
 * Class BuyRateExtension
 * @package OfficeBundle\Twig
 */
class BuyRateExtension extends \Twig_Extension
{
    private $em;

    /**
     * UserExtension constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('buyRate', array($this, 'getRate')),
        );
    }

    /**
     * @param string $currency
     * @return string
     */
    public function getRate($currency)
    {
        $settings = $this->em->getRepository('AdminSettingsBundle:MainSettings')->findOneBy(array());

        $rate = 0;

        if ($currency == 'BTC') {
            $rate = $settings->getBtcBuyRate();
        }

        return $rate;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buy_rate_extension';
    }
}