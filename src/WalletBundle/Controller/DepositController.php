<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/7/16
 * Time: 5:32 PM
 */

namespace WalletBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class DepositController
 * @package WalletBundle\Controller
 */
class DepositController extends Controller
{
    /**
     * @return array|RedirectResponse
     *
     * @Route("/deposit-bitcoin", name="office_deposit_bitcoin")
     * @Template("WalletBundle:Deposit:bitcoin.html.twig")
     */
    public function bitcoinAction()
    {
//        $sum        = $session->get('payment_sum');

        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $address    = false;
        $client     = $this->get('bitcoin.client');

        $user = $this->getUser();

        if ($user->getVerificationStatus() !== 2) {
            $this->addFlash('error', 'Please verify your account.');

            return $this->redirectToRoute('office_verification');
        }

        $qb = $em->getRepository('BitcoinBundle:BitcoinTransaction')->createQueryBuilder('btc');
        $qb
            ->where('btc.account = :account')
            ->andWhere('btc.status = false')
            ->andWhere('btc.confirmations = 0')
            ->setParameter('account', $user->getEmail());
        /** @var $transaction BitcoinTransaction */
        $transaction = $qb->getQuery()->getOneOrNullResult();
        if ($transaction) {
            $address = $transaction->getAddress();
        }

        if (!$address) {
            $btTransaction = new BitcoinTransaction();
            $btTransaction->setAccount($user->getEmail());
            $address = $client->getNewAddress($user->getEmail());
//            $address = "FPigVXwidRdfe4srzdMnqLRzDu34kXj7h2";
            $btTransaction->setAddress($address);
            $btTransaction->setDate(new \DateTime());
            $em->persist($btTransaction);

            $em->flush();
        }

        return array(
            'address'   => $address,
        );
    }

    /**
     * @return array|RedirectResponse
     *
     * @Route("/deposit-paypal", name="office_deposit_paypal")
     * @Template("WalletBundle:Deposit:paypal.html.twig")
     */
    public function payPalAction()
    {
        $user = $this->getUser();

        if ($user->getVerificationStatus() !== 2) {
            $this->addFlash('error', 'Please verify your account.');

            return $this->redirectToRoute('office_verification');
        }

        return array(
            'store' => $this->get('service_container')->getParameter('paypal_email'),
            'number'    => time(),
        );
    }
}
