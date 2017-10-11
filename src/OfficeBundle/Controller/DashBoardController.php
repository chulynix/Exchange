<?php

namespace OfficeBundle\Controller;

use APY\DataGridBundle\Grid\Row;
use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\ORM\EntityManager;
use OfficeBundle\Grid\Column\TransactionAmountColumn;
use OfficeBundle\Grid\Column\TransactionStatusColumn;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DashBoardController
 * @package OfficeBundle\Controller
 */
class DashBoardController extends Controller
{
    /**
     * @return array
     *
     * @Route("/dashboard", name="office_dashboard")
     * @Template("OfficeBundle:Office:dashboard.html.twig")
     */
    public function indexAction()
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $allNews = $em->getRepository('AdminNewsBundle:News')->findBy(array(), array('id' => 'DESC'));

        return array(
            'all_news'  => $allNews,
        );
    }

    /**
     * @return array|RedirectResponse
     * @throws \Exception
     *
     * @Route("/get-transaction", name="get_transaction")
     * @Template("OfficeBundle:Office:transaction.html.twig")
     */
    public function transactionAction()
    {
        $source = new Entity('StatisticBundle:Transaction');
        $grid = $this->get('grid');
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function ($query) use ($tableAlias) {
                /* @var $query \Doctrine\ORM\QueryBuilder */
                $query
                    ->andWhere($tableAlias.'.user = :user')
                    ->setParameter('user', $this->getUser());
            }
        );
        $grid->setSource($source);
        $grid->setId('trade');

        $grid->hideColumns(array(
            'id',
            'typeSum',
            'status',
            'sum',
            'account',
            'hash',
        ));

        $grid->getColumn('sum')->setTitle('Amount');

        $grid->getColumn('date')->setSize(200)->manipulateRenderCell(
            function($value, $row, $router) {
                $date = new \DateTime($value);

                return $date->format('M d, Y, H:i');
            }
        );

        $grid->getColumn('type')->manipulateRenderCell(
            function($value, $row, $router) {
                $result = null;

                if ($value === 0) {
                    $result = 'Buy';
                } elseif ($value === 1) {
                    $result = 'Sell';
                } elseif ($value === 2) {
                    $result = 'Deposit';
                } elseif ($value === 3) {
                    $result = 'Withdraw';
                }

                return $result;
            }
        );

        $grid->getColumn('price')->manipulateRenderCell(
            function($value, $row, $router) {
                if ($value) {
                    return $value . ' $';
                } else {
                    return '';
                }
            }
        );

        $status = new TransactionStatusColumn(array(
            'id'        => 'status',
            'title'     => 'Status',
        ));
        $grid->addColumn($status);

        $amount = new TransactionAmountColumn(array(
            'id'        => 'amount',
            'title'     => 'Amount',
        ));
        $amount->manipulateRenderCell(
            function($value, $row, $router) {
                /** @var $row Row */
                $type = $row->getField('typeSum');

                return array('type' => $type, 'sum' => $row->getField('sum'));
            }
        );
        $grid->addColumn($amount, 5);

        $grid->setDefaultOrder('id', 'DESC');
        $grid->setLimits(30);

        $grid->setRouteUrl($this->generateUrl('get_transaction'));

        if ($grid->isReadyForRedirect()) {
            return new RedirectResponse($grid->getRouteUrl());
        }

        return array(
            'grid'  => $grid,
        );
    }

    /**
     * @param string $currency
     * @return Response
     *
     * @Route("/get-rate-statistic/{currency}", name="get_rate_statistic")
     */
    public function getRateStatistic($currency = null)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $date = new \DateTime();
        $date->modify('-14 day');

        $qb = $em->getRepository('StatisticBundle:RateStatistic')->createQueryBuilder('rs');
        $qb
            ->select('rs.date, rs.rate as value, rs.volume')
            ->where('rs.currency = :currency')
            ->andWhere('rs.date > :date')
            ->setParameters(array('currency' => $currency, 'date' => $date));
        $result = $qb->getQuery()->getArrayResult();


        if ($result) {
            foreach ($result as &$value) {
                $value['date'] = $value['date']->format('Y-m-d H:i:s');
            }
        }

        return new Response(json_encode($result));
    }
}
