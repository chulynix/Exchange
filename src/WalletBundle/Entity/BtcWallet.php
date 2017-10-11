<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/15/16
 * Time: 4:20 PM
 */

namespace WalletBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Class BtcWallet
 * @package WalletBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="btc_wallets")
 */
class BtcWallet
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User", inversedBy="btcWallet")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=8)
     */
    protected $sum = 0.00000000;

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
     * Set sum
     *
     * @param string $sum
     * @return BtcWallet
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
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     * @return BtcWallet
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
}