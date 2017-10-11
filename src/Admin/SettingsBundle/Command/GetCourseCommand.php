<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/26/16
 * Time: 12:17 PM
 */

namespace Admin\SettingsBundle\Command;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GetCourseCommand
 * @package Admin\SettingsBundle\Command
 */
class GetCourseCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('settings:get:course')
            ->setDescription('Get course');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var $em EntityManager */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $html = file_get_contents('https://www.coinbase.com');
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);

        /** @var $result \DOMNodeList */
        $result = $xpath->query(".//*[@id='application_menu']/ul[2]/li[1]/a");
        if ($result->length > 0) {
            /** @var $obj \DOMElement */
            $obj = $result->item(0);
            $string = $obj->nodeValue;
            $string = trim($string);
            $arrayString = explode(" ", $string);
            $course = str_replace("$", '', $arrayString[3]);
            $course = str_replace(",", '', $course);
//var_dump($course);exit;

            if ($course > 0) {
                $settings = $em->getRepository('AdminSettingsBundle:MainSettings')->findOneBy(array());
                $settings->setBtcBuyRate($course + 500);
                $settings->setBtcSellRate($course - 300);
                $em->flush($settings);
            }
        }

        $output->writeln('ok');
    }
}
