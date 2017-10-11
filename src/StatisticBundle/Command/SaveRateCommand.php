<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/12/16
 * Time: 4:20 PM
 */

namespace StatisticBundle\Command;

use Doctrine\ORM\EntityManager;
use StatisticBundle\Entity\RateStatistic;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SaveRateCommand
 * @package StatisticBundle\Command
 */
class SaveRateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('exchange:save:rate')
            ->setDescription('Save rate statistic');
    }

    /**
     * @param InputInterface   $input
     * @param OutputInterface  $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $date   = new \DateTime();
        $date->modify("-30 min");

        /* @var $em EntityManager */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $settings = $em->getRepository('AdminSettingsBundle:MainSettings')->findOneBy(array());

        $qb = $em->getRepository('StatisticBundle:Transaction')->createQueryBuilder('t');
        $qb
            ->select('SUM(t.sum)')
            ->where('t.type = 0')
            ->andWhere("t.currency = 'BTC'")
            ->andWhere('t.date > :date')
            ->setParameter('date', $date);
        $volumeBtc = $qb->getQuery()->getSingleScalarResult() ? $qb->getQuery()->getSingleScalarResult() : 0;

        $qb = $em->getRepository('StatisticBundle:Transaction')->createQueryBuilder('t');
        $qb
            ->select('SUM(t.sum)')
            ->where('t.type = 0')
            ->andWhere('t.date > :date')
            ->setParameter('date', $date);

        $btcStat = new RateStatistic();
        $btcStat->setCurrency('BTC');
        $btcStat->setDate(new \DateTime());
        $btcStat->setRate($settings->getBtcBuyRate());
        $btcStat->setVolume($volumeBtc);
        $em->persist($btcStat);


        $em->flush();

        $output->writeln('ok!');
    }
}
