<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 2/18/16
 * Time: 10:23 AM
 */

namespace StatisticBundle\EventListener;

use Doctrine\ORM\EntityManager;
use StatisticBundle\Entity\Transaction;
use StatisticBundle\Entity\TransactionStatistic;
use StatisticBundle\Event\TransactionEvent;
use UserBundle\Entity\User;

/**
 * Class TransactionListener
 * @package StatisticBundle\EventListener
 */
class TransactionListener
{
    protected $em;

    /**
     * RegisterListener constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em       = $em;
    }

    /**
     * @param TransactionEvent $event
     */
    public function addTransaction(TransactionEvent $event)
    {
        /** @var $user User */
        $user       = $event->getUser();
        $type       = $event->getType();
        $currency   = $event->getCurrency();
        $sum        = $event->getSum();
        $typeSum    = $event->getTypeSum();
        $status     = $event->getStatus();
        $price      = $event->getPrice();
        $account    = $event->getAccount();
        $hash       = $event->getHash();

        $transaction    = new Transaction();
        $transaction->setUser($user);
        $transaction->setType($type);
        $transaction->setCurrency($currency);
        $transaction->setSum($sum);
        $transaction->setTypeSum($typeSum);
        $transaction->setStatus($status);
        $transaction->setPrice($price);
        $transaction->setAccount($account);
        $transaction->setHash($hash);

        $this->em->persist($transaction);
        $this->em->flush($transaction);
    }
}
