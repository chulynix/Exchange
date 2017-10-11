<?php

namespace ApiBundle\Controller;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiController
 * @package ApiBundle\Controller
 */
class ApiController extends FOSRestController
{
    /**
     * @return Response
     *
     * @Route("/exchange-info", name="exchange_get_info")
     */
    public function indexAction()
    {
        $data = array();

        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $pairs = array('BTC', '');

        foreach ($pairs as $pair) {
            $info = array();

            // Get last price
            $qb = $em->getRepository('StatisticBundle:Transaction')->createQueryBuilder('t');
            $qb
                ->select('t.price')
                ->where('t.type = 0')
                ->andWhere('t.currency = :currency')
                ->setParameter('currency', $pair)
                ->orderBy('t.id', 'DESC')
                ->setMaxResults(1);
            $info['lastPrice'] = ($qb->getQuery()->getResult()) ? $qb->getQuery()->getSingleScalarResult() : 0;

            // Get volume 10 min
            $date = new \DateTime();
            $date->modify('-10 min');
            $qb = $em->getRepository('StatisticBundle:Transaction')->createQueryBuilder('t');
            $qb
                ->select('SUM(t.sum * t.price)')
                ->where('t.type = 0')
                ->andWhere('t.currency = :currency')
                ->andWhere('t.date >= :date')
                ->setParameters(array('currency' => $pair, 'date' => $date));
            $info['volume10min'] = ($qb->getQuery()->getSingleScalarResult()) ? round($qb->getQuery()->getSingleScalarResult(), 8) : 0;
            $info['volume10min'] = (string) $info['volume10min'];

            // Get volume 24 hours
            $date = new \DateTime();
//            $date->setTime(0, 0, 0);
            $date->modify('-24 hour');
            $qb = $em->getRepository('StatisticBundle:Transaction')->createQueryBuilder('t');
            $qb
                ->select('SUM(t.sum * t.price) as volume, COUNT(t.id) as number')
                ->where('t.type = 0')
                ->andWhere('t.currency = :currency')
                ->andWhere('t.date >= :date')
                ->setParameters(array('currency' => $pair, 'date' => $date));
            $result = $qb->getQuery()->getResult();
            $info['volume24hours'] = (string) $result[0]['volume'];

            $data[$pair.'_USD'] = $info;
        }

        $view = $this->view($data, 200);

        return $this->handleView($view);
    }
}
