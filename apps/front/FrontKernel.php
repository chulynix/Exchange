<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class FrontKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new APY\DataGridBundle\APYDataGridBundle(),
            new Vich\UploaderBundle\VichUploaderBundle(),
            new UserBundle\UserBundle(),
            new WalletBundle\WalletBundle(),
            new OfficeBundle\OfficeBundle(),
            new StatisticBundle\StatisticBundle(),
            new Admin\NewsBundle\AdminNewsBundle(),
            new Admin\SettingsBundle\AdminSettingsBundle(),
            new Admin\FaqBundle\AdminFaqBundle(),
            new ExchangeBundle\ExchangeBundle(),
            new SupportBundle\SupportBundle(),
            new HomeBundle\HomeBundle(),
            new BackupBundle\BackupBundle(),
            new ApiBundle\ApiBundle(),
            new FOS\RestBundle\FOSRestBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
