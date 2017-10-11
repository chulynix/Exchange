<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/17/15
 * Time: 2:53 PM
 */

namespace BackupBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class BackupCommand
 * @package ExchangeBundle\Command
 */
class BackupCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('backup:save:database')
            ->setDescription('Save database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $date   = new \DateTime();

        $user       = $this->getContainer()->get('service_container')->getParameter('database_user');
        $password   = $this->getContainer()->get('service_container')->getParameter('database_password');
        $database   = $this->getContainer()->get('service_container')->getParameter('database_name');

        $files = scandir('/root/dump/');
        unset($files[0]);
        unset($files[1]);
        $oldDate = new \DateTime();
        $oldDate->modify('-1 day');
        foreach ($files as $file) {
            if (filectime('/root/dump/'.$file) < $oldDate->getTimestamp()) {
                unlink('/root/dump/'.$file);
            }
        }
        exec('mysqldump -u '.$user.' -p'.$password.' '.$database.' > /root/dump/'.$date->format("d_m_Y__H_i").'.sql');

        $output->writeln('ok!');
    }
}
