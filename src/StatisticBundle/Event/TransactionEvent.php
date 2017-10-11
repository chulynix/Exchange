<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 2/18/16
 * Time: 10:11 AM
 */

namespace StatisticBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use UserBundle\Entity\User;

/**
 * Class TransactionEvent
 * @package StatisticBundle\Event
 */
class TransactionEvent extends Event
{
    protected $user;
    protected $type;
    protected $currency;
    protected $sum;
    protected $typeSum;
    protected $status;
    protected $price;
    protected $account;
    protected $hash;

    /**
     * TransactionEvent constructor.
     * @param User    $user
     * @param int     $type
     * @param string  $currency
     * @param float   $sum
     * @param boolean $typeSum
     * @param int     $status
     * @param float   $price
     * @param string  $account
     * @param string  $hash
     */
    public function __construct(User $user, $type, $currency, $sum, $typeSum, $status, $price = null, $account = null, $hash = null)
    {
        $this->user     = $user;
        $this->type     = $type;
        $this->currency = $currency;
        $this->sum      = $sum;
        $this->typeSum  = $typeSum;
        $this->status   = $status;
        $this->price    = $price;
        $this->account  = $account;
        $this->hash     = $hash;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return float
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @return bool
     */
    public function getTypeSum()
    {
        return $this->typeSum;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return float|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return float|null
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }
}
