<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/14/16
 * Time: 3:16 PM
 */

namespace UserBundle\Security\TwoFactor\Email;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use UserBundle\Entity\User;

/**
 * Class Helper
 * @package UserBundle\Security\TwoFactor
 */
class Helper
{
    /**
     * @var \Doctrine\ORM\EntityManager $em
     */
    private $em;

    /**
     * @var object $mailer
     */
    private $mailer;

    /**
     * Construct the helper service for mail authenticator
     * @param \Doctrine\ORM\EntityManager $em
     * @param object                      $mailer
     */
    public function __construct(EntityManager $em, $mailer)
    {
        $this->em       = $em;
        $this->mailer   = $mailer;
    }

    /**
     * Generate a new authentication code an send it to the user
     * @param \UserBundle\Entity\User $user
     */
    public function generateAndSend(User $user)
    {
        $code = mt_rand(1000, 9999);
        $user->setTwoFactorCode($code);
        $this->em->persist($user);
        $this->em->flush();
        $this->sendCode($user);
    }

    /**
     * Validates the code, which was entered by the user
     * @param \UserBundle\Entity\User $user
     * @param int                     $code
     *
     * @return bool
     */
    public function checkCode(User $user, $code)
    {
        return $user->getTwoFactorCode() == $code;
    }

    /**
     * Generates the attribute key for the session
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     *
     * @return string
     */
    public function getSessionKey(TokenInterface $token)
    {
        return sprintf('two_factor_%s_%s', $token->getProviderKey(), $token->getUsername());
    }

    /**
     * Send email with code to user
     * @param \UserBundle\Entity\User $user
     */
    private function sendCode(User $user)
    {

        $message = \Swift_Message::newInstance();
        $message
            ->setTo($user->getEmail())
            ->setSubject("Authentication Code")
            ->setBody($user->getTwoFactorCode());
        $this->mailer->send($message);
    }
}
