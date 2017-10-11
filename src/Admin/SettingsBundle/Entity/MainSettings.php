<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 21.03.16
 * Time: 10:02
 */

namespace Admin\SettingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class MainSettings
 * @package Admin\SettingsBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="main_settings")
 */
class MainSettings
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="host_name")
     */
    protected $hostName;

    /**
     * @ORM\Column(type="decimal", scale=2, name="btc_buy_rate")
     */
    protected $btcBuyRate;

    /**
     * @ORM\Column(type="decimal", scale=2, name="btc_sell_rate")
     */
    protected $btcSellRate;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=8, name="limit_buy_btc")
     */
    protected $limitBuyBtc = 0.00;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=8, name="limit_sell_btc")
     */
    protected $limitSellBtc = 0.00;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set hostName
     *
     * @param string $hostName
     *
     * @return MainSettings
     */
    public function setHostName($hostName)
    {
        $this->hostName = $hostName;

        return $this;
    }

    /**
     * Get hostName
     *
     * @return string
     */
    public function getHostName()
    {
        return $this->hostName;
    }

    /**
     * Set btcBuyRate
     *
     * @param string $btcBuyRate
     *
     * @return MainSettings
     */
    public function setBtcBuyRate($btcBuyRate)
    {
        $this->btcBuyRate = $btcBuyRate;

        return $this;
    }

    /**
     * Get btcBuyRate
     *
     * @return string
     */
    public function getBtcBuyRate()
    {
        return $this->btcBuyRate;
    }

    /**
     * Set btcSellRate
     *
     * @param string $btcSellRate
     *
     * @return MainSettings
     */
    public function setBtcSellRate($btcSellRate)
    {
        $this->btcSellRate = $btcSellRate;

        return $this;
    }

    /**
     * Get btcSellRate
     *
     * @return string
     */
    public function getBtcSellRate()
    {
        return $this->btcSellRate;
    }



    /**
     * Set limitBuyBtc
     *
     * @param string $limitBuyBtc
     *
     * @return MainSettings
     */
    public function setLimitBuyBtc($limitBuyBtc)
    {
        $this->limitBuyBtc = $limitBuyBtc;

        return $this;
    }

    /**
     * Get limitBuyBtc
     *
     * @return string
     */
    public function getLimitBuyBtc()
    {
        return $this->limitBuyBtc;
    }

    /**
     * Set limitSellBtc
     *
     * @param string $limitSellBtc
     *
     * @return MainSettings
     */
    public function setLimitSellBtc($limitSellBtc)
    {
        $this->limitSellBtc = $limitSellBtc;

        return $this;
    }

    /**
     * Get limitSellBtc
     *
     * @return string
     */
    public function getLimitSellBtc()
    {
        return $this->limitSellBtc;
    }


}
