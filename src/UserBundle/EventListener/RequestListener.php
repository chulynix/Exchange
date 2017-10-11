<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/14/16
 * Time: 3:30 PM
 */

namespace UserBundle\EventListener;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use UserBundle\Entity\User;
use UserBundle\Security\TwoFactor\Email\Helper;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class RequestListener
 * @package UserBundle\EventListener
 */
class RequestListener implements EventSubscriberInterface
{
    /**
     * @var \UserBundle\Security\TwoFactor\Email\Helper $helper
     */
    protected $helper;

    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage  $securityContext
     */
    protected $securityContext;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface $templating
     */
    protected $templating;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router $router
     */
    protected $router;

    /**
     * Construct the listener
     * @param \UserBundle\Security\TwoFactor\Email\Helper                                $helper
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage $securityContext
     * @param \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface                 $templating
     * @param \Symfony\Bundle\FrameworkBundle\Routing\Router                             $router
     */
    public function __construct(Helper $helper, TokenStorage $securityContext, EngineInterface $templating, Router $router)
    {
        $this->helper           = $helper;
        $this->securityContext  = $securityContext;
        $this->templating       = $templating;
        $this->router           = $router;
    }

    /**
     * Listen for request events
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $session = $event->getRequest()->getSession();

        $token = $this->securityContext->getToken();

        if (!$token) {
            return;
        }

        /** @var $user User */
        $user = $this->securityContext->getToken()->getUser();
        if ($user !== 'anon.') {
            if (!$user->isEnabled()) {
                //Redirect to user's dashboard
                $redirect = new RedirectResponse($this->router->generate("home_index"));
                $event->setResponse($redirect);
                $session->getFlashBag()->set("error", "Your account blocked!");

                return;
            }
        }

        if (!$token instanceof UsernamePasswordToken) {
            return;
        }

        $key = $this->helper->getSessionKey($this->securityContext->getToken());
        $request = $event->getRequest();

        /** @var $user User */
        $user = $this->securityContext->getToken()->getUser();



        //Check if user has to do two-factor authentication
        if (!$session->has($key)) {
            return;
        }

        if ($session->get($key) === true) {
            return;
        }

        if ($request->getMethod() == 'POST') {
            //Check the authentication code
            if ($this->helper->checkCode($user, $request->get('_auth_code')) == true) {
                //Flag authentication complete
                $session->set($key, true);

                //Redirect to user's dashboard
//                $redirect = new RedirectResponse($this->router->generate("user_dashboard"));
//                $event->setResponse($redirect);
                return;
            } else {
                $session->getFlashBag()->set("error", "The verification code is not valid.");
            }
        }

        //Force authentication code dialog
        $response = $this->templating->renderResponse('UserBundle:TwoFactor:email.html.twig');
        $event->setResponse($response);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array(array('onKernelRequest', 2)),
        );
    }
}