<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/14/16
 * Time: 3:25 PM
 */

namespace UserBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;
use UserBundle\Entity\User;
use UserBundle\Security\TwoFactor\Email\Helper;

/**
 * Class InteractiveLoginListener
 * @package UserBundle\EventListener
 */
class InteractiveLoginListener implements EventSubscriberInterface
{
    /** @var $helper \UserBundle\Security\TwoFactor\Email\Helper */
    private $helper;

    /**
     * Construct a listener, which is handling successful authentication
     * @param \UserBundle\Security\TwoFactor\Email\Helper $helper
     */
    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            SecurityEvents::INTERACTIVE_LOGIN => 'onSecurityInteractiveLogin',
        );
    }

    /**
     * Listen for successful login events
     * @param \Symfony\Component\Security\Http\Event\InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        if (!$event->getAuthenticationToken() instanceof UsernamePasswordToken) {
            return;
        }

        //Check if user can do two-factor authentication
        $token  = $event->getAuthenticationToken();
        $user   = $token->getUser();

        if (!$user instanceof User) {
            return;
        }

        if (!$user->getTwoFactorAuthentication()) {
            //Set flag in the session
            $event->getRequest()->getSession()->set($this->helper->getSessionKey($token), null);

            //Generate and send a new security code
            $this->helper->generateAndSend($user);
        }
    }
}
