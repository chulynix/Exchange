<?php

namespace ExchangeBundle\Controller;

use Doctrine\ORM\EntityManager;
use StatisticBundle\Event\TransactionEvent;
use StatisticBundle\StatisticEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use UserBundle\Entity\User;

/**
 * Class ExchangeController
 * @package ExchangeBundle\Controller
 */
class ExchangeController extends Controller
{
    /**
     * @param Request $request
     * @return array
     *
     * @Route("/buy-sell", name="office_exchange_buy_sell")
     * @Template("ExchangeBundle::exchange.html.twig")
     */
    public function indexAction(Request $request)
    {
        $form = 1;

        // Buy Form
        $buyForm = $this->get('form.factory')->createNamedBuilder('buy_form')
            ->add('currency', ChoiceType::class, array(
                'choices'       => array('BTC', ''),
                'expanded'      => true,
                'data'          => 0,
                'constraints'   => array(new NotBlank()),
            ))
            ->add('sum', NumberType::class, array(
                'constraints'   => array(new NotBlank()),
                'label'         => 'office.accounts.sum',
            ))
            ->getForm();

        // Sell Form
        $sellForm = $this->get('form.factory')->createNamedBuilder('sell_form')
            ->add('currency', ChoiceType::class, array(
                'choices'       => array('BTC', ''),
                'expanded'      => true,
                'data'          => 0,
                'constraints'   => array(new NotBlank()),
            ))
            ->add('sum', NumberType::class, array(
                'constraints'   => array(new NotBlank()),
                'label'         => 'office.accounts.sum',
            ))
            ->getForm();

        if ($request->isMethod('POST')) {
            $translator = $this->get('translator');

            /** @var $em EntityManager */
            $em = $this->getDoctrine()->getManager();

            $settings = $em->getRepository('AdminSettingsBundle:MainSettings')->findOneBy(array());

            /** @var $user User */
            $user = $this->getUser();
            $usdWallet = $user->getUsdWallet();
            $btcWallet = $user->getBtcWallet();
            $dispatcher = $this->get('event_dispatcher');

            $limitDate = new \DateTime();
            $limitDate->modify('-7 day');

            if ($request->request->has('buy_form')) {
                $form = 1;
                $buyForm->handleRequest($request);
                if ($buyForm->isValid()) {
                    $currency   = $buyForm->get('currency')->getData();
                    $sum        = $buyForm->get('sum')->getData();

                    // If BTC
                    if (!$currency) {
                        if ($usdWallet->getSum() >= $sum * $settings->getBtcBuyRate()) {
                            if ($user->getVerificationStatus() != 2) {
                                $qb = $em->getRepository('StatisticBundle:Transaction')->createQueryBuilder('t');
                                $qb
                                    ->select('SUM(t.sum)')
                                    ->where('t.user = :user')
                                    ->andWhere('t.type = 0')
                                    ->andWhere("t.currency = 'BTC'")
                                    ->andWhere('t.date > :date')
                                    ->setParameters(array('user' => $user, 'date' => $limitDate));
                                $sumBuyed = ($qb->getQuery()->getSingleScalarResult()) ? $qb->getQuery()->getSingleScalarResult() : 0;

                                if ($sumBuyed + $sum <= $settings->getLimitBuyBtc()) {
                                    $usdWallet->setSum($usdWallet->getSum() - $sum * $settings->getBtcBuyRate());

                                    $btcWallet->setSum($btcWallet->getSum() + $sum);
                                    $event = new TransactionEvent($user, 0, 'BTC', $sum, 1, 1, $settings->getBtcBuyRate());
                                    $dispatcher->dispatch(StatisticEvents::TRANSACTION, $event);

                                    $em->flush();

                                    $this->addFlash('success', $translator->trans('office.exchange.buy_success'));

                                    return $this->redirectToRoute('office_exchange_buy_sell');
                                } else {
                                    $this->addFlash('error', $translator->trans('office.exchange.limit_error'));
                                }
                            } else {
                                $usdWallet->setSum($usdWallet->getSum() - $sum * $settings->getBtcBuyRate());

                                $btcWallet->setSum($btcWallet->getSum() + $sum);
                                $event = new TransactionEvent($user, 0, 'BTC', $sum, 1, 1, $settings->getBtcBuyRate());
                                $dispatcher->dispatch(StatisticEvents::TRANSACTION, $event);

                                $em->flush();

                                $this->addFlash('success', $translator->trans('office.exchange.buy_success'));

                                return $this->redirectToRoute('office_exchange_buy_sell');
                            }
                        } else {
                            $buyForm->get('sum')->addError(new FormError($translator->trans('office.exchange.not_funds')));
                        }
                    } else {
                            if ($user->getVerificationStatus() != 2) {
                                $qb = $em->getRepository('StatisticBundle:Transaction')->createQueryBuilder('t');
                                $qb
                                    ->select('SUM(t.sum)')
                                    ->where('t.user = :user')
                                    ->andWhere('t.type = 0')
                                    ->andWhere("t.currency = ''")
                                    ->andWhere('t.date > :date')
                                    ->setParameters(array('user' => $user, 'date' => $limitDate));
                                $sumBuyed = ($qb->getQuery()->getSingleScalarResult()) ? $qb->getQuery()->getSingleScalarResult() : 0;


                                    $dispatcher->dispatch(StatisticEvents::TRANSACTION, $event);

                                    $em->flush();

                                    $this->addFlash('success', $translator->trans('office.exchange.buy_success'));

                                    return $this->redirectToRoute('office_exchange_buy_sell');
                                } else {
                                    $this->addFlash('error', $translator->trans('office.exchange.limit_error'));
                                }
                            } else {

                                $dispatcher->dispatch(StatisticEvents::TRANSACTION, $event);

                                $em->flush();

                                $this->addFlash('success', $translator->trans('office.exchange.buy_success'));

                                return $this->redirectToRoute('office_exchange_buy_sell');
                            }
                        } else {
                            $buyForm->get('sum')->addError(new FormError($translator->trans('office.exchange.not_funds')));
                        }
                    }
                }
            }

            if ($request->request->has('sell_form')) {
                $form = 0;
                $sellForm->handleRequest($request);
                if ($sellForm->isValid()) {
                    $currency   = $sellForm->get('currency')->getData();
                    $sum        = $sellForm->get('sum')->getData();

                    if (!$currency) {
                        if ($btcWallet->getSum() >= $sum) {
                            if ($user->getVerificationStatus() != 2) {
                                $qb = $em->getRepository('StatisticBundle:Transaction')->createQueryBuilder('t');
                                $qb
                                    ->select('SUM(t.sum)')
                                    ->where('t.user = :user')
                                    ->andWhere('t.type = 1')
                                    ->andWhere("t.currency = 'BTC'")
                                    ->andWhere('t.date > :date')
                                    ->setParameters(array('user' => $user, 'date' => $limitDate));
                                $sumSelled = ($qb->getQuery()->getSingleScalarResult()) ? $qb->getQuery()->getSingleScalarResult() : 0;

                                if ($sumSelled + $sum <= $settings->getLimitSellBtc()) {
                                    $btcWallet->setSum($btcWallet->getSum() - $sum);
                                    $event = new TransactionEvent($user, 1, 'BTC', $sum, 0, 1, $settings->getBtcSellRate());
                                    $dispatcher->dispatch(StatisticEvents::TRANSACTION, $event);

                                    $usdWallet->setSum($usdWallet->getSum() + $sum * $settings->getBtcSellRate());

                                    $em->flush();

                                    $this->addFlash('success', $translator->trans('office.exchange.sell_success'));

                                    return $this->redirectToRoute('office_exchange_buy_sell');
                                } else {
                                    $this->addFlash('error', $translator->trans('office.exchange.limit_error'));
                                }
                            } else {
                                $btcWallet->setSum($btcWallet->getSum() - $sum);
                                $event = new TransactionEvent($user, 1, 'BTC', $sum, 0, 1, $settings->getBtcSellRate());
                                $dispatcher->dispatch(StatisticEvents::TRANSACTION, $event);

                                $usdWallet->setSum($usdWallet->getSum() + $sum * $settings->getBtcSellRate());

                                $em->flush();

                                $this->addFlash('success', $translator->trans('office.exchange.sell_success'));

                                return $this->redirectToRoute('office_exchange_buy_sell');
                            }
                        } else {
                            $sellForm->get('sum')->addError(new FormError($translator->trans('office.exchange.not_funds')));
                        }
                    } else {
                            if ($user->getVerificationStatus() != 2) {
                                $qb = $em->getRepository('StatisticBundle:Transaction')->createQueryBuilder('t');
                                $qb
                                    ->select('SUM(t.sum)')
                                    ->where('t.user = :user')
                                    ->andWhere('t.type = 1')
                                    ->andWhere("t.currency = ''")
                                    ->andWhere('t.date > :date')
                                    ->setParameters(array('user' => $user, 'date' => $limitDate));
                                $sumSelled = ($qb->getQuery()->getSingleScalarResult()) ? $qb->getQuery()->getSingleScalarResult() : 0;

                                    $dispatcher->dispatch(StatisticEvents::TRANSACTION, $event);


                                    $em->flush();

                                    $this->addFlash('success', $translator->trans('office.exchange.sell_success'));

                                    return $this->redirectToRoute('office_exchange_buy_sell');
                                } else {
                                    $this->addFlash('error', $translator->trans('office.exchange.limit_error'));
                                }
                            } else {
                                $dispatcher->dispatch(StatisticEvents::TRANSACTION, $event);


                                $em->flush();

                                $this->addFlash('success', $translator->trans('office.exchange.sell_success'));

                                return $this->redirectToRoute('office_exchange_buy_sell');
                            }
                        } else {
                            $sellForm->get('sum')->addError(new FormError($translator->trans('office.exchange.not_funds')));
                        }
                    }
                }
            }
        }

        return array(
            'buy_form'  => $buyForm->createView(),
            'sell_form' => $sellForm->createView(),
            'form'      => $form,
        );
    }
}
