<?php

namespace Admin\WalletBundle\Controller;

use Admin\WalletBundle\Grid\Column\BankDataColumn;
use Admin\WalletBundle\Grid\Column\StatusColumn;
use APY\DataGridBundle\Grid\Action\MassAction;
use APY\DataGridBundle\Grid\Column\DateColumn;
use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Row;
use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\ORM\EntityManager;
use StatisticBundle\Entity\Transaction;
use StatisticBundle\Entity\WalletStatistic;
use StatisticBundle\Event\TransactionEvent;
use StatisticBundle\StatisticEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use UserBundle\Entity\User;

/**
 * Class WalletController
 * @package Admin\WalletBundle\Controller
 */
class WalletController extends Controller
{
    /**
     * @return array
     *
     * @Route("/wallet-deposit", name="admin_wallet_deposit")
     * @Template("AdminWalletBundle::deposit.html.twig")
     */
    public function depositAction()
    {
        $source = new Entity('StatisticBundle:Transaction');
        $grid = $this->get('grid');
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function ($query) use ($tableAlias) {
                /* @var $query \Doctrine\ORM\QueryBuilder */
                $query
                    ->andWhere($tableAlias.'.type = 2')
                    ->andWhere($tableAlias.'.status = 1');
            }
        );

        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
            'type',
            'status',
            'price',
            'typeSum',
            'hash',
        ));

        $grid->getColumn('id')->setFilterable(false);
        $grid->getColumn('type')->setFilterable(false);
        $grid->getColumn('typeSum')->setFilterable(false);
        $grid->getColumn('status')->setFilterable(false);
        $grid->getColumn('hash')->setFilterable(false);

        $user = new TextColumn(array(
            'id'    => 'username',
            'field' => 'user.username',
            'source'    => true,
            'title' => 'User',
        ));
        $user->setSize(200);
        $grid->addColumn($user, 1);

        $grid->getColumn('sum')->setTitle('Сумма');
        $grid->getColumn('sum')->manipulateRenderCell(
            function($value, $row, $router) {

                return $value;
            }
        );
        $grid->getColumn('currency')->setTitle('Валюта');

        $grid->getColumn('username')->setOperators(array('like'))->setDefaultOperator('like')->setOperatorsVisible(false);
        $grid->getColumn('date')->setOperators(array('like'))->setDefaultOperator('like')->setOperatorsVisible(false);
        $grid->getColumn('sum')->setOperators(array('like'))->setDefaultOperator('like')->setOperatorsVisible(false);
        $grid->getColumn('account')->setOperators(array('like'))->setDefaultOperator('like')->setOperatorsVisible(false);
        $grid->getColumn('currency')->setOperators(array('like'))->setDefaultOperator('like')->setOperatorsVisible(false);
        $grid->getColumn('price')->setOperators(array('like'))->setDefaultOperator('like')->setOperatorsVisible(false);

        $grid->setDefaultOrder('id', 'DESC');

        if ($grid->isReadyForRedirect()) {
            return new RedirectResponse($grid->getRouteUrl());
        }

        return array(
            'grid'  => $grid,
        );
    }

    /**
     * @return array
     *
     * @Route("/wallet-withdraw", name="admin_wallet_withdraw")
     * @Template("AdminWalletBundle::withdraw.html.twig")
     */
    public function withdrawAction()
    {
        $source = new Entity('StatisticBundle:Transaction');
        $grid = $this->get('grid');
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function ($query) use ($tableAlias) {
                /* @var $query \Doctrine\ORM\QueryBuilder */
                $query
                    ->andWhere($tableAlias.'.type = 3');
            }
        );

        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
            'type',
            'status',
            'typeSum',
            'price',
            'hash',
        ));

        $grid->getColumn('sum')->setTitle('Сумма');
        $grid->getColumn('sum')->manipulateRenderCell(
            function($value, $row, $router) {

                return $value;
            }
        );
        $grid->getColumn('account')->setTitle('Аккаунт');
        $grid->getColumn('currency')->setTitle('Валюта');

        $user = new TextColumn(array(
            'id'    => 'username',
            'field' => 'user.username',
            'source'    => true,
            'title' => 'User',
        ));
        $grid->addColumn($user, 1);

        $bankData = new BankDataColumn(array(
            'id'    => 'bank_data',
            'title' => 'Bank data',
        ));
        $bankData->manipulateRenderCell(
            function($value, $row, $router) {
                /** @var $row Row */
                $data = $row->getField('currency');
                if ($data == 'USD' && $row->getField('account') == null) {
                    return $row->getField('id');
                }

                return null;
            }
        );
        $grid->addColumn($bankData, 11);

        $statusColumn = new StatusColumn(array(
            'id'        => 'statusId',
            'title'     => 'status',
        ));
        $statusColumn->manipulateRenderCell(
        /** @var $row Row */
            function($value, $row, $router) {
                return $row->getField('status');
            }
        );
        $grid->addColumn($statusColumn);

        $grid->getColumn('id')->setFilterable(false);
        $grid->getColumn('type')->setFilterable(false);
        $grid->getColumn('price')->setFilterable(false);
        $grid->getColumn('typeSum')->setFilterable(false);
        $grid->getColumn('bank_data')->setFilterable(false);
        $grid->getColumn('hash')->setFilterable(false);
        $grid->getColumn('date')->setFilterable(false);
        $grid->getColumn('statusId')->setFilterable(false);
        $grid->getColumn('username')->setOperators(array('like'))->setDefaultOperator('like')->setOperatorsVisible(false);
        $grid->getColumn('sum')->setOperators(array('like'))->setDefaultOperator('like')->setOperatorsVisible(false);
        $grid->getColumn('account')->setOperators(array('like'))->setDefaultOperator('like')->setOperatorsVisible(false);
        $grid->getColumn('status')->setTitle('Статус')->setSize(-1)->setOperators(array('eq'))->setDefaultOperator('eq')->setOperatorsVisible(false)->setFilterType('select')->setValues(array(0 => 'В ожидании', 1 => 'Выплачен', 2 => 'Возврат'))->setSelectExpanded(true);
        $grid->getColumn('currency')->setTitle('Валюта')->setSize(-1)->setOperators(array('eq'))->setDefaultOperator('eq')->setOperatorsVisible(false)->setFilterType('select')->setValues(array('USD' => 'USD', '' => '', 'BTC' => 'BTC'))->setSelectExpanded(true);
//        $date = new DateColumn(array(
//            'id'    => 'date',
//            'title' => 'Период',
//            'visible'   => false,
//        ));
//        $date->setOperators(array('btw'))->setDefaultOperator('btw')->setOperatorsVisible(false)->setClass('datepicker');
//        $grid->addColumn($date);

        $waitAction = new MassAction('Ожидание', 'Admin\WalletBundle\Controller\WalletController::waitAction', true, array('em' => $this->getDoctrine()->getManager()), null);
        $grid->addMassAction($waitAction);

        $doneAction = new MassAction('Выплачено', 'Admin\WalletBundle\Controller\WalletController::doneAction', true, array('em' => $this->getDoctrine()->getManager()), null);
        $grid->addMassAction($doneAction);

        $dispatcher = $this->get('event_dispatcher');
        $refundAction = new MassAction('Возврат', 'Admin\WalletBundle\Controller\WalletController::refundAction', true, array('em' => $this->getDoctrine()->getManager(), 'dispatcher' => $dispatcher), null);
        $grid->addMassAction($refundAction);

        $grid->setDefaultOrder('id', 'DESC');

        if ($grid->isReadyForRedirect()) {
            return new RedirectResponse($grid->getRouteUrl());
        }

        return array(
            'grid'  => $grid,
        );
    }

    /**
     * @param array  $primaryKeys
     * @param array  $allPrimaryKeys
     * @param string $session
     * @param array  $parameters
     */
    public static function waitAction($primaryKeys, $allPrimaryKeys, $session, $parameters)
    {
        /* @var $em EntityManager */
        $em = $parameters['em'];
        foreach ($primaryKeys as $id) {
            /* @var $user Transaction */
            $transaction = $em->getRepository('StatisticBundle:Transaction')->find($id);
            $transaction->setStatus(0);
            $em->flush();
        }
    }

    /**
     * @param array  $primaryKeys
     * @param array  $allPrimaryKeys
     * @param string $session
     * @param array  $parameters
     */
    public static function doneAction($primaryKeys, $allPrimaryKeys, $session, $parameters)
    {
        /* @var $em EntityManager */
        $em = $parameters['em'];
        foreach ($primaryKeys as $id) {
            /* @var $user Transaction */
            $transaction = $em->getRepository('StatisticBundle:Transaction')->find($id);
            $transaction->setStatus(1);
            $em->flush();
        }
    }

    /**
     * @param array  $primaryKeys
     * @param array  $allPrimaryKeys
     * @param string $session
     * @param array  $parameters
     */
    public static function refundAction($primaryKeys, $allPrimaryKeys, $session, $parameters)
    {
        /* @var $em EntityManager */
        $em         = $parameters['em'];
        $dispatcher = $parameters['dispatcher'];

        foreach ($primaryKeys as $id) {
            /* @var $user Transaction */
            $transaction = $em->getRepository('StatisticBundle:Transaction')->find($id);
            $transaction->setStatus(2);

            /** @var $user User */
            $user = $transaction->getUser();

            if ($transaction->getCurrency() == 'USD') {
                $wallet = $user->getUsdWallet();
            } elseif ($transaction->getCurrency() == 'BTC') {
                $wallet = $user->getBtcWallet();
            } else {
            }

            $wallet->setSum($wallet->getSum() + $transaction->getSum());

            $em->flush();
        }
    }

    /**
     * @param int $id
     * @return array
     *
     * @Route("/wallet-bank-data/{id}", name="admin_bank_data")
     * @Template("AdminWalletBundle::bank_data.html.twig")
     */
    public function bankData($id)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $transaction = $em->getRepository('StatisticBundle:Transaction')->find($id);
        $data = $em->getRepository('WalletBundle:UsdWithdraw')->findOneBy(array(
            'transaction'   => $transaction,
        ));

        return array(
            'data'  => $data,
        );
    }
}
