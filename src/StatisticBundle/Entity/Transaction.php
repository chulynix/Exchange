<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/5/16
 * Time: 11:27 AM
 */

namespace StatisticBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;
use WalletBundle\Entity\UsdWithdraw;

/**
 * Class Transaction
 * @package StatisticBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="transactions")
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="transactions")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Column(type="integer")
     *
     * 0 - buy
     * 1 - sell
     * 2 - deposit
     * 3 - withdraw
     */
    protected $type;

    /**
     * @ORM\Column(type="string")
     */
    protected $currency;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=8)
     */
    protected $sum;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    protected $price;

    /**
     * @ORM\Column(type="boolean")
     *
     * 0 - plus
     * 1 - minus
     */
    protected $typeSum;

    /**
     * @ORM\Column(type="integer")
     *
     * 0 - wait
     * 1 - done
     * 2 - cancel
     */
    protected $status;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $account;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $hash;

    /**
     * @ORM\OneToOne(targetEntity="WalletBundle\Entity\UsdWithdraw")
     */
    protected $usdWithdraw;

    /**
     * Transaction constructor.
     */
    public function __construct()
    {
        $this->date = new \DateTime();
    }

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Transaction
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Transaction
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return Transaction
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set sum
     *
     * @param string $sum
     *
     * @return Transaction
     */
    public function setSum($sum)
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * Get sum
     *
     * @return string
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * Set typeSum
     *
     * @param boolean $typeSum
     *
     * @return Transaction
     */
    public function setTypeSum($typeSum)
    {
        $this->typeSum = $typeSum;

        return $this;
    }

    /**
     * Get typeSum
     *
     * @return boolean
     */
    public function getTypeSum()
    {
        return $this->typeSum;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Transaction
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Transaction
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Transaction
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set account
     *
     * @param string $account
     *
     * @return Transaction
     */
    public function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set hash
     *
     * @param string $hash
     *
     * @return Transaction
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set usdWithdraw
     *
     * @param \WalletBundle\Entity\UsdWithdraw $usdWithdraw
     *
     * @return Transaction
     */
    public function setUsdWithdraw(UsdWithdraw $usdWithdraw = null)
    {
        $this->usdWithdraw = $usdWithdraw;

        return $this;
    }

    /**
     * Get usdWithdraw
     *
     * @return \WalletBundle\Entity\UsdWithdraw
     */
    public function getUsdWithdraw()
    {
        return $this->usdWithdraw;
    }
}
