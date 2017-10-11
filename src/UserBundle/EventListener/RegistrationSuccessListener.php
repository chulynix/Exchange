<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/12/15
 * Time: 3:57 PM
 */

namespace UserBundle\EventListener;

use CareerBundle\Entity\UserCareer;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use UserBundle\Entity\User;
use WalletBundle\Entity\UserAccount;
use WalletBundle\Entity\UserCredit;
use WalletBundle\Entity\UserMiningAccount;
use WalletBundle\Entity\UserProfit;
use WalletBundle\Entity\UserSplitAccount;
use WalletBundle\Entity\UserToken;
use WalletBundle\Entity\UserWallet;

/**
 * Class RegistrationSuccessListener
 */
class RegistrationSuccessListener implements EventSubscriberInterface
{
    private $em;
    private $session;

    /**
     * RegistrationSuccessListener constructor.
     * @param EntityManager $em
     * @param Session       $session
     */
    public function __construct(EntityManager $em, Session $session)
    {
        $this->em       = $em;
        $this->session  = $session;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_COMPLETED => 'onRegistrationCompleted',
        );
    }

    /**
     * @param FilterUserResponseEvent $event
     */
    public function onRegistrationCompleted(FilterUserResponseEvent $event)
    {
//        dump(111);exit;
        $request    = $event->getRequest();

        /** @var $user User */
        $user       = $event->getUser();

        $date = new \DateTime('NOW');
        $user->setRegistrationDate($date);
        $user->setRegistrationIp($request->getClientIp());
        $user->setReferer($this->session->get('referer'));

        $this->em->flush($user);
    }
}
