<?php

namespace WalletBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class WalletController
 * @package WalletBundle\Controller
 */
class WalletController extends Controller
{
    /**
     * @return array
     *
     * @Route("/accounts", name="office_accounts")
     * @Template("WalletBundle::accounts.html.twig")
     */
    public function indexAction()
    {
        return array();
    }
}
