<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/7/16
 * Time: 11:38 AM
 */

namespace WalletBundle\Controller;

use Doctrine\ORM\EntityManager;
use StatisticBundle\Event\TransactionEvent;
use StatisticBundle\StatisticEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use UserBundle\Entity\User;
use WalletBundle\Entity\UsdWithdraw;
use WalletBundle\Form\UsdWithdrawType;

/**
 * Class WithdrawController
 * @package WalletBundle\Controller
 */
class WithdrawController extends Controller
{
    /**
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/withdraw-usd-paypal", name="office_withdraw_usd_paypal")
     * @Template("WalletBundle:Withdraw:usd_paypal.html.twig")
     */
    public function withdrawUsdPaypalAction(Request $request)
    {
        /** @var $user User */
        $user = $this->getUser();

        if ($user->getVerificationStatus() !== 2) {
            $this->addFlash('error', 'Please verify your account.');

            return $this->redirectToRoute('office_verification');
        }

        $form = $this->createFormBuilder()
            ->add('sum', NumberType::class, array(
                'constraints' => array(new NotBlank()),
                'label' => 'office.accounts.sum',
            ))
            ->add('account', TextType::class, array(
                'constraints'   => array(new NotBlank()),
                'label' => 'office.accounts.account',
            ))
            ->getForm();

        $translator = $this->get('translator');

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $sum = $form->get('sum')->getData();
                if ($sum >= 5) {
                    $usdWallet = $user->getUsdWallet();
                    if ($usdWallet->getSum() >= $sum) {
                        $account = $form->get('account')->getData();
                        if (filter_var($account, FILTER_VALIDATE_EMAIL)) {
                            /** @var $em EntityManager */
                            $em = $this->getDoctrine()->getManager();

                            $usdWallet->setSum($usdWallet->getSum() - $sum);
                            $em->flush();

                            $dispatcher = $this->get('event_dispatcher');
                            $event = new TransactionEvent($user, 3, 'USD', $sum, 0, 0, null, $account);
                            $dispatcher->dispatch(StatisticEvents::TRANSACTION, $event);

                            $this->addFlash('success', $translator->trans('office.accounts.withdraw_success'));

                            return $this->redirectToRoute('office_withdraw_usd_paypal');
                        } else {
                            $form->get('account')->addError(new FormError('Wrong account address!'));
                        }
                    } else {
                        $form->get('sum')->addError(new FormError($translator->trans('office.accounts.no_funds')));
                    }
                } else {
                    $form->get('sum')->addError(new FormError('Minimum amount 5$'));
                }
            }
        }

        return array(
            'form'  => $form->createView(),
        );
    }

    /**
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/withdraw-usd-wire", name="office_withdraw_usd_wire")
     * @Template("WalletBundle:Withdraw:usd_wire.html.twig")
     */
    public function withdrawUsdWireAction(Request $request)
    {
        /** @var $user User */
        $user = $this->getUser();

        if ($user->getVerificationStatus() !== 2) {
            $this->addFlash('error', 'Please verify your account.');

            return $this->redirectToRoute('office_verification');
        }

        $form = $this->createFormBuilder()
            ->add('sum', NumberType::class, array(
                'constraints'   => array(new NotBlank()),
                'label'         => 'office.accounts.sum',
            ))
            ->add('usdWithdraw', UsdWithdrawType::class, array(
//                'constraints'   => array(new NotBlank()),
                'label'         => ' ',
            ))
            ->getForm();

        $translator = $this->get('translator');

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $sum        = $form->get('sum')->getData();
                if ($sum >= 5) {
                    $usdWallet = $user->getUsdWallet();
                    if ($usdWallet->getSum() >= $sum) {
                        /** @var $bankData UsdWithdraw */
                        $bankData = $form->get('usdWithdraw')->getData();

                        /** @var $em EntityManager */
                        $em = $this->getDoctrine()->getManager();


                        $usdWallet->setSum($usdWallet->getSum() - $sum);
                        $em->flush();

                        $dispatcher = $this->get('event_dispatcher');
                        $event = new TransactionEvent($user, 3, 'USD', $sum, 0, 0);
                        $dispatcher->dispatch(StatisticEvents::TRANSACTION, $event);

                        $transaction = $em->getRepository('StatisticBundle:Transaction')->findOneBy(array(
                            'user' => $user,
                            'type' => 3,
                        ), array('id' => 'DESC'));

                        $bankData->setTransaction($transaction);
                        $em->persist($bankData);
                        $em->flush($bankData);

                        $this->addFlash('success', $translator->trans('office.accounts.withdraw_success'));

                        return $this->redirectToRoute('office_withdraw_usd_wire');
                    } else {
                        $form->get('sum')->addError(new FormError($translator->trans('office.accounts.no_funds')));
                    }
                } else {
                    $form->get('sum')->addError(new FormError('Minimum amount 5$'));
                }
            }
        }

        return array(
            'form'  => $form->createView(),
        );
    }

    /**
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/withdraw-btc", name="office_withdraw_btc")
     * @Template("WalletBundle:Withdraw:btc.html.twig")
     */
    public function withdrawBtcAction(Request $request)
    {
        /** @var $user User */
        $user = $this->getUser();

        if ($user->getVerificationStatus() !== 2) {
            $this->addFlash('error', 'Please verify your account.');

            return $this->redirectToRoute('office_verification');
        }

        $form = $this->createFormBuilder()
            ->add('sum', NumberType::class, array(
                'constraints'   => array(new NotBlank()),
                'label'         => 'office.accounts.sum',
            ))
            ->add('account', TextType::class, array(
                'constraints'   => array(new NotBlank()),
                'label'         => 'office.accounts.account',
            ))
            ->getForm();

        $translator = $this->get('translator');

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $sum        = $form->get('sum')->getData();
                if ($sum >= 0.0001) {
                    $btcWallet = $user->getBtcWallet();
                    if ($btcWallet->getSum() >= $sum) {
                        $account = $form->get('account')->getData();

                        /** @var $em EntityManager */
                        $em = $this->getDoctrine()->getManager();


                        $btcWallet->setSum($btcWallet->getSum() - $sum);
                        $em->flush();

                        $dispatcher = $this->get('event_dispatcher');
                        $event = new TransactionEvent($user, 3, 'BTC', $sum, 0, 0, null, $account);
                        $dispatcher->dispatch(StatisticEvents::TRANSACTION, $event);

                        $this->addFlash('success', $translator->trans('office.accounts.withdraw_success'));

                        return $this->redirectToRoute('office_withdraw_btc');
                    } else {
                        $form->get('sum')->addError(new FormError($translator->trans('office.accounts.no_funds')));
                    }
                } else {
                    $form->get('sum')->addError(new FormError('Minimum amount 0.0001 BTC'));
                }
            }
        }

        return array(
            'form'  => $form->createView(),
        );
    }


}
