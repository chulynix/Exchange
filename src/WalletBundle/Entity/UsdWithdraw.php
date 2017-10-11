<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/22/16
 * Time: 9:30 AM
 */

namespace WalletBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use StatisticBundle\Entity\Transaction;

/**
 * Class UsdWithdraw
 * @package WalletBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="usd_withdraw")
 */
class UsdWithdraw
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="StatisticBundle\Entity\Transaction", inversedBy="usdWithdraw")
     * @ORM\JoinColumn(name="transaction_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $transaction;

    /**
     * @ORM\Column(type="string", nullable=true, name="bank_name")
     */
    protected $bankName;

    /**
     * @ORM\Column(type="string", nullable=true, name="bank_swift_code")
     */
    protected $bankSwiftCode;

    /**
     * @ORM\Column(type="string", nullable=true, name="bank_street")
     */
    protected $bankStreet;

    /**
     * @ORM\Column(type="string", nullable=true, name="bank_city")
     */
    protected $bankCity;

    /**
     * @ORM\Column(type="string", nullable=true, name="bank_country")
     */
    protected $bankCountry;

    /**
     * @ORM\Column(type="string", nullable=true, name="bank_province_state")
     */
    protected $bankProvinceState;

    /**
     * @ORM\Column(type="string", nullable=true, name="bank_zip_postal_code")
     */
    protected $bankZipPostalCode;

    /**
     * @ORM\Column(type="string", nullable=true, name="bank_account_number")
     */
    protected $bankAccountNumber;

    /**
     * @ORM\Column(type="string", nullable=true, name="iban")
     */
    protected $iban;

    /**
     * @ORM\Column(type="string", nullable=true, name="currency")
     */
    protected $currency;

    /**
     * @ORM\Column(type="string", nullable=true, name="bank_aba_routing_code")
     */
    protected $bankAbaRoutingCode;

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
     * Set bankName
     *
     * @param string $bankName
     *
     * @return UsdWithdraw
     */
    public function setBankName($bankName)
    {
        $this->bankName = $bankName;

        return $this;
    }

    /**
     * Get bankName
     *
     * @return string
     */
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * Set bankSwiftCode
     *
     * @param string $bankSwiftCode
     *
     * @return UsdWithdraw
     */
    public function setBankSwiftCode($bankSwiftCode)
    {
        $this->bankSwiftCode = $bankSwiftCode;

        return $this;
    }

    /**
     * Get bankSwiftCode
     *
     * @return string
     */
    public function getBankSwiftCode()
    {
        return $this->bankSwiftCode;
    }

    /**
     * Set bankStreet
     *
     * @param string $bankStreet
     *
     * @return UsdWithdraw
     */
    public function setBankStreet($bankStreet)
    {
        $this->bankStreet = $bankStreet;

        return $this;
    }

    /**
     * Get bankStreet
     *
     * @return string
     */
    public function getBankStreet()
    {
        return $this->bankStreet;
    }

    /**
     * Set bankCity
     *
     * @param string $bankCity
     *
     * @return UsdWithdraw
     */
    public function setBankCity($bankCity)
    {
        $this->bankCity = $bankCity;

        return $this;
    }

    /**
     * Get bankCity
     *
     * @return string
     */
    public function getBankCity()
    {
        return $this->bankCity;
    }

    /**
     * Set bankCountry
     *
     * @param string $bankCountry
     *
     * @return UsdWithdraw
     */
    public function setBankCountry($bankCountry)
    {
        $this->bankCountry = $bankCountry;

        return $this;
    }

    /**
     * Get bankCountry
     *
     * @return string
     */
    public function getBankCountry()
    {
        return $this->bankCountry;
    }

    /**
     * Set bankProvinceState
     *
     * @param string $bankProvinceState
     *
     * @return UsdWithdraw
     */
    public function setBankProvinceState($bankProvinceState)
    {
        $this->bankProvinceState = $bankProvinceState;

        return $this;
    }

    /**
     * Get bankProvinceState
     *
     * @return string
     */
    public function getBankProvinceState()
    {
        return $this->bankProvinceState;
    }

    /**
     * Set bankZipPostalCode
     *
     * @param string $bankZipPostalCode
     *
     * @return UsdWithdraw
     */
    public function setBankZipPostalCode($bankZipPostalCode)
    {
        $this->bankZipPostalCode = $bankZipPostalCode;

        return $this;
    }

    /**
     * Get bankZipPostalCode
     *
     * @return string
     */
    public function getBankZipPostalCode()
    {
        return $this->bankZipPostalCode;
    }

    /**
     * Set bankAccountNumber
     *
     * @param string $bankAccountNumber
     *
     * @return UsdWithdraw
     */
    public function setBankAccountNumber($bankAccountNumber)
    {
        $this->bankAccountNumber = $bankAccountNumber;

        return $this;
    }

    /**
     * Get bankAccountNumber
     *
     * @return string
     */
    public function getBankAccountNumber()
    {
        return $this->bankAccountNumber;
    }

    /**
     * Set iban
     *
     * @param string $iban
     *
     * @return UsdWithdraw
     */
    public function setIban($iban)
    {
        $this->iban = $iban;

        return $this;
    }

    /**
     * Get iban
     *
     * @return string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return UsdWithdraw
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
     * Set bankAbaRoutingCode
     *
     * @param string $bankAbaRoutingCode
     *
     * @return UsdWithdraw
     */
    public function setBankAbaRoutingCode($bankAbaRoutingCode)
    {
        $this->bankAbaRoutingCode = $bankAbaRoutingCode;

        return $this;
    }

    /**
     * Get bankAbaRoutingCode
     *
     * @return string
     */
    public function getBankAbaRoutingCode()
    {
        return $this->bankAbaRoutingCode;
    }

    /**
     * Set transaction
     *
     * @param \StatisticBundle\Entity\Transaction $transaction
     *
     * @return UsdWithdraw
     */
    public function setTransaction(Transaction $transaction = null)
    {
        $this->transaction = $transaction;

        return $this;
    }

    /**
     * Get transaction
     *
     * @return \StatisticBundle\Entity\Transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }
}
