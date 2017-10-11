<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/14/16
 * Time: 3:05 PM
 */

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use StatisticBundle\Entity\Transaction;
use SupportBundle\Entity\SupportTicket;
use WalletBundle\Entity\BtcWallet;
use WalletBundle\Entity\UsdWallet;

/**
 * Class User
 * @package UserBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $surname;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $country;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $city;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", name="zip_code", nullable=true)
     */
    protected $zipCode;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $referer;

    /**
     * @ORM\Column(type="datetime", name="registration_date", nullable=true)
     */
    protected $registrationDate;

    /**
     * @ORM\Column(type="string", name="registration_ip", nullable=true)
     */
    protected $registrationIp;

    /**
     * @ORM\Column(type="string", name="last_ip", nullable=true)
     */
    protected $lastIp;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $twoFactorAuthentication = false;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $twoFactorCode;

    /**
     * @ORM\OneToOne(targetEntity="WalletBundle\Entity\BtcWallet", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $btcWallet;

    /**
     * @ORM\OneToOne(targetEntity="WalletBundle\Entity\UsdWallet", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $usdWallet;

    /**
     * @ORM\OneToMany(targetEntity="StatisticBundle\Entity\Transaction", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $transactions;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\Verification", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $verification;

    /**
     * @ORM\Column(type="integer", name="verification_status")
     *
     * 0 - no verification
     * 1 - wait
     * 2 - done
     * 3 - abort verification
     */
    protected $verificationStatus = 0;

    /**
     * @ORM\OneToMany(targetEntity="SupportBundle\Entity\SupportTicket", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $supportTickets;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $btcWallet = new BtcWallet();
        $btcWallet->setUser($this);
        $this->setBtcWallet($btcWallet);

        $usdWallet = new UsdWallet();
        $usdWallet->setUser($this);
        $this->setUsdWallet($usdWallet);
    }

    /**
     * Set twoFactorAuthentication
     *
     * @param boolean $twoFactorAuthentication
     * @return User
     */
    public function setTwoFactorAuthentication($twoFactorAuthentication)
    {
        $this->twoFactorAuthentication = $twoFactorAuthentication;

        return $this;
    }

    /**
     * Get twoFactorAuthentication
     *
     * @return boolean
     */
    public function getTwoFactorAuthentication()
    {
        return $this->twoFactorAuthentication;
    }

    /**
     * Set twoFactorCode
     *
     * @param integer $twoFactorCode
     * @return User
     */
    public function setTwoFactorCode($twoFactorCode)
    {
        $this->twoFactorCode = $twoFactorCode;

        return $this;
    }

    /**
     * Get twoFactorCode
     *
     * @return integer
     */
    public function getTwoFactorCode()
    {
        return $this->twoFactorCode;
    }

    /**
     * Set btcWallet
     *
     * @param \WalletBundle\Entity\BtcWallet $btcWallet
     * @return User
     */
    public function setBtcWallet(BtcWallet $btcWallet = null)
    {
        $this->btcWallet = $btcWallet;

        return $this;
    }

    /**
     * Get btcWallet
     *
     * @return \WalletBundle\Entity\BtcWallet
     */
    public function getBtcWallet()
    {
        return $this->btcWallet;
    }



    /**
     * Set usdWallet
     *
     * @param \WalletBundle\Entity\UsdWallet $usdWallet
     * @return User
     */
    public function setUsdWallet(UsdWallet $usdWallet = null)
    {
        $this->usdWallet = $usdWallet;

        return $this;
    }

    /**
     * Get usdWallet
     *
     * @return \WalletBundle\Entity\UsdWallet
     */
    public function getUsdWallet()
    {
        return $this->usdWallet;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set referer
     *
     * @param string $referer
     *
     * @return User
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;

        return $this;
    }

    /**
     * Get referer
     *
     * @return string
     */
    public function getReferer()
    {
        return $this->referer;
    }

    /**
     * Set registrationDate
     *
     * @param \DateTime $registrationDate
     *
     * @return User
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return \DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * Set registrationIp
     *
     * @param string $registrationIp
     *
     * @return User
     */
    public function setRegistrationIp($registrationIp)
    {
        $this->registrationIp = $registrationIp;

        return $this;
    }

    /**
     * Get registrationIp
     *
     * @return string
     */
    public function getRegistrationIp()
    {
        return $this->registrationIp;
    }

    /**
     * Set lastIp
     *
     * @param string $lastIp
     *
     * @return User
     */
    public function setLastIp($lastIp)
    {
        $this->lastIp = $lastIp;

        return $this;
    }

    /**
     * Get lastIp
     *
     * @return string
     */
    public function getLastIp()
    {
        return $this->lastIp;
    }

    /**
     * Add transaction
     *
     * @param \StatisticBundle\Entity\Transaction $transaction
     *
     * @return User
     */
    public function addTransaction(\StatisticBundle\Entity\Transaction $transaction)
    {
        $this->transactions[] = $transaction;

        return $this;
    }

    /**
     * Remove transaction
     *
     * @param \StatisticBundle\Entity\Transaction $transaction
     */
    public function removeTransaction(Transaction $transaction)
    {
        $this->transactions->removeElement($transaction);
    }

    /**
     * Get transactions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * Set verificationStatus
     *
     * @param integer $verificationStatus
     *
     * @return User
     */
    public function setVerificationStatus($verificationStatus)
    {
        $this->verificationStatus = $verificationStatus;

        return $this;
    }

    /**
     * Get verificationStatus
     *
     * @return integer
     */
    public function getVerificationStatus()
    {
        return $this->verificationStatus;
    }

    /**
     * Set verification
     *
     * @param \UserBundle\Entity\Verification $verification
     *
     * @return User
     */
    public function setVerification(Verification $verification = null)
    {
        $this->verification = $verification;

        return $this;
    }

    /**
     * Get verification
     *
     * @return \UserBundle\Entity\Verification
     */
    public function getVerification()
    {
        return $this->verification;
    }

    /**
     * Add supportTicket
     *
     * @param \SupportBundle\Entity\SupportTicket $supportTicket
     *
     * @return User
     */
    public function addSupportTicket(SupportTicket $supportTicket)
    {
        $this->supportTickets[] = $supportTicket;

        return $this;
    }

    /**
     * Remove supportTicket
     *
     * @param \SupportBundle\Entity\SupportTicket $supportTicket
     */
    public function removeSupportTicket(SupportTicket $supportTicket)
    {
        $this->supportTickets->removeElement($supportTicket);
    }

    /**
     * Get supportTickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSupportTickets()
    {
        return $this->supportTickets;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     *
     * @return User
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }
}
