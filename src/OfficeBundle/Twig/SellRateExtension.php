<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/5/16
 * Time: 3:28 PM
 */

namespace OfficeBundle\Twig;

use Doctrine\ORM\EntityManager;

/**
 * Class SellRateExtension
 * @package OfficeBundle\Twig
 */
class SellRateExtension extends \Twig_Extension
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
            new \Twig_SimpleFilter('sellRate', array($this, 'getRate')),
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
            $rate = $settings->getBtcSellRate();
        }

        return $rate;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sell_rate_extension';
    }
}